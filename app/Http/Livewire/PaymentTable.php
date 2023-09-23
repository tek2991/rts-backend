<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\{Button, Column, Detail, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns, Responsive};

final class PaymentTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public string $sortField = 'id';
    public string $sortDirection = 'desc';

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
            // Detail::make()
            //     ->view('detail-rows.payment-detail')
            //     ->showCollapseIcon(),

            // Responsive::make()
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
     * @return Builder<\App\Models\Payment>
     */
    public function datasource(): Builder
    {
        return Payment::query();
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
            ->addColumn('payment_id')

            ->addColumn('payment_link', fn (Payment $model) => '<a href="' . route('payment.show', $model->id) . '" class="text-blue-500 hover:text-blue-600 hover:underline font-semibold">' . $model->payment_id .  '</a>')

            /** Example of custom column using a closure **/
            // ->addColumn('payment_id_lower', fn (Payment $model) => strtolower(e($model->payment_id)))

            // ->addColumn('webhook_payment_id')
            ->addColumn('payment_request_id')
            ->addColumn('payment_status')
            // ->addColumn('currency')
            // ->addColumn('amount_in_cents')
            ->addColumn('amount')
            ->addColumn('amount_formatted', fn (Payment $model) => '₹ ' . number_format($model->amount, 2, ',', '.'))
            ->addColumn('instrument_type')
            ->addColumn('billing_instrument')
            ->addColumn('failure_reason')
            ->addColumn('failure_message')
            ->addColumn('bank_reference_number')
            ->addColumn('buyer_name')
            ->addColumn('buyer_email')
            ->addColumn('buyer_phone')
            ->addColumn('purpose')
            // ->addColumn('shorturl')
            // ->addColumn('longurl')
            ->addColumn('mac')
            ->addColumn('redirected')
            ->addColumn('redirected_formatted', fn (Payment $model) => $model->redirected ? 'Yes' : 'No')
            ->addColumn('webhook_verified')
            ->addColumn('webhook_verified_formatted', fn (Payment $model) => $model->webhook_verified ? 'Yes' : 'No')
            ->addColumn('user_id')
            ->addColumn('created_at_formatted', fn (Payment $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
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
            // Column::make('Id', 'id'),
            Column::make('Payment', 'payment_link', 'payment_id')
                ->sortable()
                ->searchable(),

            // Column::make('Webhook payment id', 'webhook_payment_id')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Currency', 'currency')
            //     ->sortable()
            //     ->searchable(),

            Column::make('Amount', 'amount_formatted', 'amount')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'payment_status')
                ->sortable()
                ->searchable(),

            Column::make('Redirected', 'redirected_formatted', 'redirected'),

            Column::make('Webhook verified', 'webhook_verified_formatted', 'webhook_verified'),

            // Column::make('Billing instrument', 'billing_instrument')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Failure message', 'failure_message')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Bank reference number', 'bank_reference_number')
            //     ->sortable()
            //     ->searchable(),

            Column::make('Name', 'buyer_name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'buyer_email')
                ->sortable()
                ->searchable(),

            Column::make('Phone', 'buyer_phone')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Purpose', 'purpose')
                ->sortable()
                ->searchable(),

            // Column::make('Shorturl', 'shorturl')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Longurl', 'longurl')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('User id', 'user_id'),

            Column::make('Mac', 'mac')
                ->sortable()
                ->searchable(),

            Column::make('Payment request id', 'payment_request_id')
                ->sortable()
                ->searchable(),

            Column::make('Instrument', 'instrument_type')
                ->sortable()
                ->searchable(),

            Column::make('Failure reason', 'failure_reason')
                ->sortable()
                ->searchable(),

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
            Filter::boolean('redirected'),
            Filter::boolean('webhook_verified'),
            Filter::datetimepicker('created_at'),
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
     * PowerGrid Payment Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('payment.edit', function(\App\Models\Payment $model) {
                    return $model->id;
               }),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('payment.destroy', function(\App\Models\Payment $model) {
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
     * PowerGrid Payment Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($payment) => $payment->id === 1)
                ->hide(),
        ];
    }
    */
}
