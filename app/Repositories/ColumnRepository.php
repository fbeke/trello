<?php


namespace App\Repositories;


use App\Column;
use App\Dashboard;
use App\Events\ColumnCreated;
use App\Events\ColumnDeleted;

class ColumnRepository
{

    private $data;


    /**
     * @param array $data
     *
     * @return Column
     */
    public function store(array $data): Column
    {
        $this->data = $data;

        $this->setSort();

        $column = Column::create($this->data);

        event(new ColumnCreated($column));

        return $column;
    }


    /**
     * get maximum sort field for specific dashboard and set it up for new Column
     */
    private function setSort()
    {
        $this->data['sort'] = Column::where('dashboard_id', $this->data['dashboard_id'])->max('sort');
    }


    public function update(Column $column, array $data)
    {
        $column->update($data);

        return $column;
    }


    public function delete(Column $column)
    {
        $column->delete();

        event(new ColumnDeleted($column));
    }


    /**
     * update sort field for columns from one dashboard just
     *
     * @param Dashboard $dashboard
     * @param array $set
     */
    public function sort(Dashboard $dashboard, array $set)
    {
        return Column::where('dashboard_id', $dashboard->id)
            ->get()
            ->each(function ($column) use ($set) {
                if (!in_array($column->id, $set['set']))
                    return true;

                $column->sort = array_search($column->id, $set['set']);
                $column->save();
            });

    }
}
