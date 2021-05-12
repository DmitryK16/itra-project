<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\Company;
use App\Models\News;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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

        $config = (new GridConfig())
            ->setDataProvider(new EloquentDataProvider(
                    (new News())::leftJoin('companies', 'companies.id', '=', 'news.company_id')
                        ->select('news.*', 'companies.name as company_name')
                        ->where('companies.user_id', $user->id)
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
            ]);

        $grid = new Grid($config);

        return view('admin.news.list')
            ->with('grid', $grid);
    }

    public function create(): Factory|View|Application
    {
        $companies = Company::where('user_id', Auth::id())->get();

        $companiesMapped = [];

        foreach ($companies as $company) {
            $companiesMapped[$company->id] = $company->name;
        }

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
}
