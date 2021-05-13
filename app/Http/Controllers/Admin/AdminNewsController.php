<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Company;
use App\Models\News;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;

class AdminNewsController extends Controller
{
    public function list(): Factory|View|Application
    {
        /** @var User $user */
        $user = Auth::user();

        $query = (new News())::leftJoin('companies', 'companies.id', '=', 'news.company_id')
            ->select('news.*', 'companies.name as company_name');

        if (!$user->isAdmin()) {
            $query->where('companies.user_id', $user->id);
        }

        $config = (new GridConfig())
            ->setDataProvider(new EloquentDataProvider(
                    $query
                        ->groupBy('news.id')
                        ->newQuery()
                )
            )
            ->setColumns([
                (new FieldConfig)
                    ->setName('company_name')
                    ->setLabel('Название компании')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('company_name')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                            ->setFilteringFunc(function ($value, EloquentDataProvider $provider) {
                                $provider
                                    ->getBuilder()
                                    ->where('companies.name', 'like', "%{$value}%");
                            })
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('name')
                    ->setLabel('Название новости')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('name')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('img')
                    ->setLabel('Фото')
                    ->setCallback(function ($value) {
                        if (empty($value)) {
                            return 'None img';
                        }

                        return "<img src={$value} width='120' height='50' />";
                    }),
                (new FieldConfig)
                    ->setName('id')
                    ->setLabel('Actions')
                    ->setCallback(function ($value) {

                        return "<a href='/admin/news/edit/$value'> Edit</a>
                                     &thinsp;
                                     <a href='/admin/news/delete/$value' data-element-id='$value' data-form-delete>Delete</a>
                                    ";
                    }),
            ]);

        $grid = new Grid($config);

        return view('admin.news.list')
            ->with('grid', $grid);
    }

    public function create(): Factory|View|Application
    {
        $companiesMapped = $this->getCompanies();

        return view('admin.news.create')->with('companiesMapped', $companiesMapped);
    }

    public function store(NewsRequest $request): Redirector|RedirectResponse|Application
    {
        $result = $request->execute();

        if (!empty($result)) {
            return redirect(route('admin_news'))->with('success', 'Запись успешно добавлена');
        }

        return back()->with('error', 'Возникли некоторые ошибки');
    }

    public function edit(News $news)
    {
        $companiesMapped = $this->getCompanies();

        return view('admin.news.edit')
            ->with('news', $news)
            ->with('companiesMapped', $companiesMapped);
    }

    protected function getCompanies()
    {
        $user = Auth::user();
        $companies = Company::where('user_id', $user->id)->get();

        if ($user->isAdmin()) {
            $companies = Company::all();
        }

        $companiesMapped = [];

        foreach ($companies as $company) {
            $companiesMapped[$company->id] = $company->name;
        }

        return $companiesMapped;
    }

    public function update(News $news, UpdateRequest $request)
    {
        $result = $request->update($news);

        if (!empty($result)) {
            return redirect(route('admin_news'))->with('success', 'Запись успешно добавлена');
        }

        return back()->with('error', 'Возникли некоторые ошибки');
    }

    public function delete(News $news)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            if ($news->company()->user_id === $user->id && $news->delete()) {
                return [
                    'message' => 'Запись успешно удалена',
                    'status' => 'ok'
                ];
            }

            return [
                'message' => 'Не удалось удалить запись',
                'status' => 'error'
            ];
        }

        $news->delete();

        return [
            'message' => 'Запись успешно удалена',
            'status' => 'ok'
        ];
    }
}
