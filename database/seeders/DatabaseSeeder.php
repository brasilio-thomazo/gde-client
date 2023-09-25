<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\StorageType;
use App\Models\Department;
use App\Models\DocumentImage;
use App\Models\DocumentType;
use App\Models\Document;
use App\Models\Group;
use App\Models\Search;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    private function createSearches(): array
    {
        $searches = [];

        $searches[] = Search::factory()->create([
            'name' => 'Universal',
            'show_field' => [
                'document_type' => true,
                'department' => true,
                'code' => true,
                'identity' => true,
                'name' => true,
                'comment' => true,
                'storage' => true,
            ]
        ])->id;

        $searches[] = Search::factory()->create([
            'name' => 'Nominal',
            'show_field' => [
                'document_type' => true,
                'department' => true,
                'code' => true,
                'identity' => false,
                'name' => true,
                'comment' => false,
                'storage' => false,
            ]
        ])->id;

        $searches[] = Search::factory()->create([
            'name' => 'Cliente',
            'show_field' => [
                'document_type' => true,
                'department' => false,
                'code' => true,
                'identity' => false,
                'name' => false,
                'comment' => false,
                'storage' => false,
            ]
        ])->id;

        return $searches;
    }

    private function createDepartments(): array
    {
        $departments = [];
        $departments[] = Department::factory()->create(['name' => 'System'])->id;
        $departments[] = Department::factory()->create(['name' => 'Clientes'])->id;
        $departments[] = Department::factory()->create(['name' => 'Recursos Humanos'])->id;
        $departments[] = Department::factory()->create(['name' => 'Departamento financeiro'])->id;
        $departments[] = Department::factory()->create(['name' => 'Departamento jurídico'])->id;
        return $departments;
    }

    private function createDocumentTypes(): array
    {
        $documet_types = [];
        $documet_types[] = DocumentType::factory()->create(['name' => 'Nota fiscal'])->id;
        $documet_types[] = DocumentType::factory()->create(['name' => 'Contrato'])->id;
        $documet_types[] = DocumentType::factory()->create(['name' => 'Boleto'])->id;
        $documet_types[] = DocumentType::factory()->create(['name' => 'Manual'])->id;
        $documet_types[] = DocumentType::factory()->create(['name' => 'Comprovante'])->id;
        return $documet_types;
    }

    private function createGroups(array $document_types, array $departments): array
    {
        $rw = ['group' => 'rw', 'user' => 'rw', 'search' => 'rw', 'document' => 'rw'];
        $r = ['group' => 'r', 'user' => 'r', 'search' => 'r', 'document' => 'r'];
        $rd = ['document' => 'r'];
        $rdrw = ['group' => 'r', 'user' => 'r', 'search' => 'r', 'document' => 'rw'];

        $groups = [];


        $groups[] = Group::factory()->create([
            'name' => 'Administradores',
            'privilege' => $rw,
            'authorities' => Group::makeAuthorities($rw),
            'types' => [0],
            'departments' => [0],
            'custom' => [],
            'searches' => [0],
        ])->id;

        $groups[] = Group::factory()->create([
            'name' => 'Usuários',
            'privilege' => $r,
            'authorities' => Group::makeAuthorities($r),
            'types' => [0],
            'departments' => [0],
            'custom' => [],
            'searches' => [0],
        ])->id;

        $groups[] = Group::factory()->create([
            'name' => 'Financeiro',
            'privilege' => $rdrw,
            'authorities' => Group::makeAuthorities($rdrw),
            'types' => [$document_types[0], $document_types[2]],
            'departments' => [$departments[1]],
            'custom' => [],
            'searches' => [0],
        ])->id;

        $groups[] = Group::factory()->create([
            'name' => 'Clientes',
            'privilege' => $rd,
            'authorities' => Group::makeAuthorities($rd),
            'types' => [0],
            'departments' => [0],
            'custom' => [['documents' => 'identity', 'users' => 'identity']],
            'searches' => [0],
        ])->id;

        return $groups;
    }

    private function createUsers(array $groups, array $departments): array
    {
        $users = [];

        $users[] = User::factory()->create([
            'name' => 'Sistema',
            'department_id' => $departments[0],
            'identity' => '',
            'phone' => '',
            'email' => 'postmaster@localhost',
            'username' => 'system',
            'password' => 'system'
        ])->groups()->attach($groups[0]);

        $users[] = User::factory()->create([
            'name' => 'Administrador',
            'identity' => '',
            'department_id' => $departments[0],
            'phone' => '',
            'email' => 'admin@localhost',
            'username' => 'admin',
            'password' => 'admin'
        ])->groups()->attach($groups[0]);

        return $users;
    }

    public function run(): void
    {
        $searches = $this->createSearches();
        $departments = $this->createDepartments();
        $document_types = $this->createDocumentTypes();
        $groups = $this->createGroups($document_types, $departments);
        $users = $this->createUsers($groups, $departments);
        $dirs = [['boleto'], ['comprovante'], ['contrato'], ['fiscal'], ['e-book', 'manual']];
        /*
        $fake = fake();

        for ($i = 0; $i < 50; $i++) {
            $type_index = rand(0, count($document_types) - 1);
            $department_index = rand(0, count($departments) - 1);
            $dir_index = $type_index < count($dirs) ? $type_index : rand(0, count($dirs) - 1);

            $doc = new Document([
                'document_type_id' => $document_types[$type_index],
                'department_id' => $departments[$department_index],
                'code' => Str::random(8),
                'identity' => $fake->cnpj(false),
                'name' => $fake->name(),
                'comment' => $fake->text(),
                'storage' => Str::random(5),
                'date_document' => $fake->dateTimeThisYear()->format('Y-m-d')
            ]);
            $doc->save();

            $dir = getcwd() . '/test/files/';
            $dir .= count($dirs[$dir_index]) == 1 ? $dirs[$dir_index][0] : $dirs[$dir_index][rand(0, count($dirs[$dir_index]) - 1)];
            foreach (scandir($dir) as $file) {
                if (str_ends_with($file, ".tiff")) {
                    $filename = sprintf('%s/%s', $dir, $file);
                    DocumentImage::factory()->create([
                        'document_id' => $doc->id,
                        'filename' => $filename,
                        'storage_type' => StorageType::LOCAL,
                    ]);
                }
            }
        }
        */
    }
}
