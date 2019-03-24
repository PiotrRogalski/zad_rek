<?php

use App\Enum\Permissions;
use App\Model\Group;
use App\Model\Permission;
use App\Model\Position;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $groups = [
        'Dział IT',
        'Obszar Marketingu',
        'Dział Public Relations',
        'Dział Eksportu',
        'Dział Zakupów',
        'Dział Finansów',
        'Dział Księgowości',
        'Dział Prawny',
        'Dział HR',
        'Dział Kadr',
        'Dział Rozwoju',
        'Dział Jakości',
        'Dział Produkcji',
        'Dział Logistyki',
        'Dział Handlowy',
    ];

    protected $positions = [
        'Telemarketer',
        'Dyrektor',
    ];

    protected $taskTitles = [
        'Utworzenie konta klienta',
        'Pozycjonowanie strony',
    ];

    /** @var Permission */
    private $employeePermission;
    /** @var Permission */
    private $managerPermission;

    public function __construct()
    {
        $this->employeePositionId = factory(Position::class)->create([
            'name' => 'Pracownik',
        ]);
    }


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->seedPermissions();
        $this->seedGroups();
        $this->seedPositions();
        $this->seedTasks();

        $this->createEmployee();
        $this->createManager();
        factory(User::class, 10)->create([
            'permission_id' => Permissions::EMPLOYEE,
        ]);

        // Populate the pivot table
        App\User::all()->each(function ($user) use ($task) {
            $user->tasks()->attach(
                $task->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }

    private function seedPermissions()
    {
        $permissionIds = [
            'employeePermission' => Permissions::EMPLOYEE,
            'managerPermission' => Permissions::MANAGER,
        ];

        foreach ($permissionIds as $field => $id) {
            $this->{$field} = factory(Permission::class)->create([
                'id' => $id,
                'name' => Permissions::trans($id),
            ]);
        }
    }

    private function seedGroups()
    {
        foreach ($this->groups as $group) {
            factory(App\Model\Group::class)->create([
                'name' => $group,
            ]);
        }
    }

    private function seedPositions()
    {
        foreach ($this->positions as $position) {
            factory(App\Model\Position::class)->create([
                'name' => $position,
            ]);
        }
    }

    private function seedTasks()
    {
        foreach ($this->taskTitles as $title) {
            factory(App\Model\Task::class)->create([
                'title' => $title,
            ]);
        }
    }

    public function createEmployee(): void
    {
        if ($this->employeePermission === null) {
            throw new LogicException('Missing employee permission. Tip: seed permissions table using seedPermissions method.');
        }
        $this->createUser(
            'Pracownik',
            'pracownik@koni.pl',
            Group::query()->inRandomOrder()->first(),
            Position::query()->inRandomOrder()->first(),
            $this->employeePermission
        );
    }

    private function createUser(
        string $firstName,
        string $email,
        ?Group $group = null,
        ?Position $position = null,
        ?Permission $permission = null
    ): User {
        return factory(\App\User::class)->create([
            'name' => $firstName,
            'email' => $email,
            'group_id' => $group->id ?? null,
            'position_id' => $position->id ?? null,
            'permission_id' => $permission->id ?? null,
        ]);
    }

    private function createManager()
    {
        if ($this->managerPermission === null) {
            throw new LogicException('Missing manager permission. Tip: seed permissions table using seedPermissions method.');
        }
        $this->createUser(
            'Menadżer',
            'menadzer@koni.pl',
            Group::query()->inRandomOrder()->first(),
            Position::query()->inRandomOrder()->first(),
            $this->managerPermission
        );
    }
}
