<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Subject;
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

/**
 * Class CompanyController
 * @package App\Http\Controllers
 */
class AdminCompanyController extends Controller
{
    public function list(): Factory|View|Application
    {
        /** @var User $user */
        $user = Auth::user();

        $query = (new Company())::leftJoin('subjects', 'subjects.id', '=', 'companies.subject_id')
            ->select('companies.*', 'subjects.name as subject_name');

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $config = (new GridConfig())
            ->setDataProvider(new EloquentDataProvider(
                    $query
                        ->groupBy('companies.id')
                        ->orderBy('created_at', 'DESC')
                        ->newQuery()
                )
            )
            ->setPageSize(15)
            ->setColumns([
                (new FieldConfig)
                    ->setName('subject_name')
                    ->setLabel('Тематика')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('subject_name')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                            ->setFilteringFunc(function ($value, EloquentDataProvider $provider) {
                                $provider
                                    ->getBuilder()
                                    ->where('subject.name', 'like', "%{$value}%");
                            })
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('name')
                    ->setLabel('Название')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('name')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('small_descriptions')
                    ->setLabel('Описание')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('small_descriptions')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    ),
                (new FieldConfig)
                    ->setName('required_amount')
                    ->setLabel('Целевая сумма денег')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('amount')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('deposited_amount')
                    ->setLabel('Внесенная сумма денег')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('amount')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('id')
                    ->setLabel('Actions')
                    ->setCallback(function ($value) {

                        return "<a href='/admin/company/delete/$value' data-element-id='$value' data-form-delete>Delete</a>
                                    ";
                    }),
            ]);

        $grid = new Grid($config);

        return view('admin.company.list')
            ->with('grid', $grid);
    }

    public function create(): Factory|View|Application
    {
        $subjects = $this->getSubjects();

        return view('admin.company.create')->with('subjects', $subjects);
    }

    public function store(CompanyRequest $request): Redirector|RedirectResponse|Application
    {
        $result = $request->execute();

        if (!empty($result)) {
            return redirect(route('admin_companies'))->with('success', 'Запись успешно добавлена');
        }

        return back()->with('error', 'Возникли некоторые ошибки');
    }

    public function delete(Company $company)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            if ($company->user_id === $user->id && $company->delete()) {
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

        $company->delete();

        return [
            'message' => 'Запись успешно удалена',
            'status' => 'ok'
        ];
    }

    protected function getSubjects()
    {
        $subjects = Subject::all();

        $subjectsMapped = [];

        foreach ($subjects as $subject) {
            $subjectsMapped[$subject->id] = $subject->name;
        }

        return $subjectsMapped;
    }
}
