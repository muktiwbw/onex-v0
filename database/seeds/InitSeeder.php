<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Privilege;
use App\Level;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Grand Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('adminadmin'),
        ]);

        $privilege = Privilege::create([
            'user_id' => $user->id,
            'type' => 'ADMIN'
        ]);

        $levels = ['Beginner', 'Intermediate I', 'Intermediate II', 'Advance'];

        foreach ($levels as $level) {
            Level::create([
                'name' => $level,
                'tujuan' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi consequat dictum lacus eget elementum. Pellentesque in lobortis sem, mattis volutpat nisl. Sed ac lacus id eros auctor eleifend. Donec sed erat quis nisl consequat hendrerit at nec purus. Nulla facilisi. Praesent maximus tellus id turpis porta tristique. Fusce interdum augue id malesuada luctus. Quisque ac scelerisque risus. Nullam ut tellus a quam varius malesuada id vitae tortor. Quisque ut ligula faucibus, dapibus risus sit amet, rutrum risus. Vivamus ultricies vestibulum nisi. Nulla consectetur metus aliquet molestie molestie. Etiam semper efficitur ullamcorper. Integer et ex vel lectus porttitor sollicitudin vitae ut dolor. Proin pharetra ante euismod rhoncus vestibulum.',
                'uraian' => 'Curabitur hendrerit suscipit ipsum, eu pharetra lorem gravida eget. Nulla sed neque justo. Phasellus efficitur, ligula quis bibendum tristique, diam purus porttitor sapien, eget venenatis mauris diam at mauris. Morbi vel felis at nisl ornare posuere nec aliquet diam. Vivamus pellentesque condimentum urna, vitae ornare tellus egestas nec. Donec consequat metus erat, in accumsan neque pretium vel. Curabitur a congue sapien.'
            ]);
        }
    }
}
