<?php

namespace App\Http\Livewire;

use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class SubscriptionTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Subscription>
     */
    public function datasource(): Builder
    {
        return Subscription::query()->with('user', 'payment');
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('user_id')
            ->addColumn('user.name', fn (Subscription $model) => $model->user->name)
            ->addColumn('user.email', fn (Subscription $model) => $model->user->email)
            ->addColumn('user.mobile_number', fn (Subscription $model) => $model->user->mobile_number)
            ->addColumn('package_id')
            ->addColumn('package_name')

            /** Example of custom column using a closure **/
            ->addColumn('package_name_lower', fn (Subscription $model) => strtolower(e($model->package_name)))

            ->addColumn('coupon_id')
            ->addColumn('coupon_code')
            ->addColumn('coupon_promoter_name')
            ->addColumn('activation_code_id')
            ->addColumn('activation_code')
            ->addColumn('plan_net_amount')
            ->addColumn('plan_tax')
            ->addColumn('started_at_formatted', fn (Subscription $model) => Carbon::parse($model->started_at)->format('d/m/Y H:i:s'))
            ->addColumn('expires_at_formatted', fn (Subscription $model) => Carbon::parse($model->expires_at)->format('d/m/Y H:i:s'))
            ->addColumn('duration_in_days')
            ->addColumn('gross_price')
            ->addColumn('discount_amount')
            ->addColumn('net_amount')
            ->addColumn('tax')
            ->addColumn('price')
            ->addColumn('payment_method')
            ->addColumn('status')
            ->addColumn('payment_id')
            ->addColumn('payment.payment_id', fn (Subscription $model) => $model->payment ? $model->payment->payment_id : null)
            ->addColumn('created_at_formatted', fn (Subscription $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('User', 'user.name', 'user_id'),
            Column::make('User email', 'user.email', 'user_id'),
            Column::make('User mobile number', 'user.mobile_number', 'user_id'),

            Column::make('Package', 'package_name')
                ->sortable()
                ->searchable(),
            Column::make('Coupon code', 'coupon_code')
                ->sortable()
                ->searchable(),

            Column::make('Activation code', 'activation_code')
                ->sortable()
                ->searchable(),

            Column::make('Duration in days', 'duration_in_days'),

            Column::make('Plan net amount', 'plan_net_amount'),
            Column::make('Started at', 'started_at_formatted', 'started_at')
                ->sortable(),
            Column::make('Expires at', 'expires_at_formatted', 'expires_at')
                ->sortable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Payment id', 'payment.payment_id'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Subscription Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('subscription.edit', function(\App\Models\Subscription $model) {
                    return $model->id;
               }),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('subscription.destroy', function(\App\Models\Subscription $model) {
                    return $model->id;
               })
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Subscription Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($subscription) => $subscription->id === 1)
                ->hide(),
        ];
    }
    */
}
