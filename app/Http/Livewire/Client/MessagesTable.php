<?php

namespace App\Http\Livewire\Client;

use App\Models\Message;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Responsive;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class MessagesTable extends PowerGridComponent
{
    use ActionButton;
    // use WithExport;

    public string $sortField = 'date';

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
        // $this->showCheckBox();

        return [
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            // Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),

            Responsive::make(),
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
     * @return Builder<\App\Models\Message>
     */
    public function datasource(): Builder
    {
        return Message::query()->where('user_id', auth()->user()->id);
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
            ->addColumn('device_id')

            /** Example of custom column using a closure **/
            ->addColumn('device_id_lower', fn (Message $model) => strtolower(e($model->device_id)))

            ->addColumn('message_id')
            ->addColumn('number')
            ->addColumn('date_formatted', fn (Message $model) => Carbon::parse($model->date)->format('d/m/Y H:i'))
            ->addColumn('body')
            ->addColumn('body_formatted', function (Message $model) {
                // Line breaks on the next space after every 50 characters
                $body = wordwrap($model->body, 50, "\n", true);

                // Replace the line breaks with <br>
                $body = nl2br($body);

                // Return the body
                return $body;
            })
            ->addColumn('is_inbox')
            ->addColumn('is_inbox_formatted', fn (Message $model) => $model->is_inbox ? 'Inbox' : 'Outbox')
            ->addColumn('created_at_formatted', fn (Message $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
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
            Column::make('Number', 'number')
                ->sortable()
                ->searchable(),

            Column::make('Date', 'date_formatted', 'date')
                ->sortable(),

            Column::make('Type', 'is_inbox_formatted', 'is_inbox')
                ->sortable()
                ->searchable(),

            Column::make('Device id', 'device_id')
                ->sortable()
                ->searchable(),

            Column::make('Body', 'body_formatted', 'body')
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
            // Filter::inputText('number')->operators(['contains']),
            // Filter::datetimepicker('date'),
            Filter::boolean('is_inbox')
                ->label('Inbox', 'Outbox'),
            // Filter::inputText('device_id')->operators(['contains']),
            // Filter::inputText('body')->operators(['contains'])
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
     * PowerGrid Message Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('message.edit', function(\App\Models\Message $model) {
                    return $model->id;
               }),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('message.destroy', function(\App\Models\Message $model) {
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
     * PowerGrid Message Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($message) => $message->id === 1)
                ->hide(),
        ];
    }
    */
}
