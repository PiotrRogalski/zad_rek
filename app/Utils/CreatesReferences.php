<?php

namespace App\Utils;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Str;

trait CreatesReferences
{
    /**
     * @param string                                $referencedTable
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param null|string                           $foreignKey
     * @param string                                $onDelete
     * @param string                                $onUpdate
     * @param string                                $references
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function references(
        string $referencedTable,
        Blueprint $table,
        ?string $foreignKey = null,
        string $onDelete = 'cascade',
        string $onUpdate = 'cascade',
        string $references = 'id'
    ): ColumnDefinition {
        if ($foreignKey === null) {
            $foreignKey = $this->foreignKeyName($referencedTable);
        }

        $columnDefinition = $table->unsignedBigInteger($foreignKey);
        $table->foreign($foreignKey)
              ->references($references)
              ->on($referencedTable)
              ->onDelete($onDelete)
              ->onUpdate($onUpdate);

        return $columnDefinition;
    }

    private function foreignKeyName(string $referencedTable): string
    {
        $singular = Str::singular($referencedTable);
        $foreignKey = "{$singular}_id";

        return $foreignKey;
    }
}
