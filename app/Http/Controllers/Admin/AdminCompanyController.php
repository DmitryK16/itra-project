<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
            ]);

        $grid = new Grid($config);

        return view('admin.company.list')
            ->with('grid', $grid);
    }
}
