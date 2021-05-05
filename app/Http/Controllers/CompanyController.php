<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
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
class CompanyController extends Controller
{
    public function list()
    {
        /** @var User $user */
        $user = Auth::user();
        $companies = $user->companies;

        $config = (new GridConfig())
            ->setDataProvider(new EloquentDataProvider(
                    (new Company())::leftJoin('subjects', 'subjects.id', '=', 'companies.subject_id')
                        ->select('companies.*', 'subjects.name as subject_name')
                        ->where('user_id', $user->id)
                        ->groupBy('companies.id')
                        ->newQuery()
                )
            )
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
                    ->setName('amount')
                    ->setLabel('Сумма денег')
                    ->addFilter(
                        (new FilterConfig)
                            ->setName('amount')
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    )
                    ->setSortable(true),
            ]);

        $grid = new Grid($config);

        return view('company.list')
            ->with('companies', $companies)
            ->with('grid', $grid);
    }
}
