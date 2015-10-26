<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('PlansTableSeeder');
		$this->call('SectorsTableSeeder');
		$this->call('MomentosTableSeeder');
		$this->call('CanalsTableSeeder');
		$this->call('EncuestaTableSeeder');
		$this->call('CiudadsTableSeeder');
		$this->call('PaisTableSeeder');
		$this->call('Pregunta_cabecerasTableSeeder');
		$this->call('RegionsTableSeeder');
		$this->call('TipousuariosTableSeeder');
		$this->call('ClientesTableSeeder');
		$this->call('EstadosTableSeeder');
		$this->call('AparienciaTableSeeder');
		$this->call('MomentoencuestaTableSeeder');
		$this->call('UsuariosTableSeeder');
	}

}
