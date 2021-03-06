<?php

class ArrayGroupTest extends PHPUnit_Framework_TestCase
{

	protected $states;

	protected $numbers;

	public function setUp()
	{
		$this->states = [
			[
				'state'  => 'IN',
				'city'   => 'Indianapolis',
				'object' => 'School bus',
			],
			[
				'state'  => 'IN',
				'city'   => 'Indianapolis',
				'object' => 'Manhole',
			],
			[
				'state'  => 'IN',
				'city'   => 'Plainfield',
				'object' => 'Basketball',
			],
			[
				'state'  => 'CA',
				'city'   => 'San Diego',
				'object' => 'Light bulb',
			],
			[
				'state'  => 'CA',
				'city'   => 'Mountain View',
				'object' => 'Space pen',
			],
		];

		$this->numbers = [
			[1, 'Only a cat of a different coat'],
			[1, 'That\'s all the truth I know'],
			[2, 'That I must bow so low'],
		];
	}

	public function testGroupStringFirstLevel()
	{
		$expected = ['IN', 'CA'];

		$this->assertEquals($expected, array_keys(array_group_by($this->states, 'state')));
	}

	public function testGroupByState()
	{
		$expected = [
			'IN' => [
				[
					'state'  => 'IN',
					'city'   => 'Indianapolis',
					'object' => 'School bus',
				],
				[
					'state'  => 'IN',
					'city'   => 'Indianapolis',
					'object' => 'Manhole',
				],
				[
					'state'  => 'IN',
					'city'   => 'Plainfield',
					'object' => 'Basketball',
				],
			],
			'CA' => [
				[
					'state'  => 'CA',
					'city'   => 'San Diego',
					'object' => 'Light bulb',
				],
				[
					'state'  => 'CA',
					'city'   => 'Mountain View',
					'object' => 'Space pen',
				],
			],
		];

		$this->assertEquals($expected, array_group_by($this->states, 'state'));
	}

	public function testGroupByStateCity()
	{
		$expected = [
			'IN' => [
				'Indianapolis' => [
					[
						'state'  => 'IN',
						'city'   => 'Indianapolis',
						'object' => 'School bus',
					],
					[
						'state'  => 'IN',
						'city'   => 'Indianapolis',
						'object' => 'Manhole',
					],
				],
				'Plainfield'   => [
					[
						'state'  => 'IN',
						'city'   => 'Plainfield',
						'object' => 'Basketball',
					],
				],
			],
			'CA' => [
				'San Diego'     => [
					[
						'state'  => 'CA',
						'city'   => 'San Diego',
						'object' => 'Light bulb',
					],
				],
				'Mountain View' => [
					[
						'state'  => 'CA',
						'city'   => 'Mountain View',
						'object' => 'Space pen',
					],
				],
			],
		];

		$this->assertEquals($expected, array_group_by($this->states, 'state', 'city'));
	}

	public function testGroupByInt()
	{
		$expected = [
			1 => [
				[1, 'Only a cat of a different coat'],
				[1, 'That\'s all the truth I know'],
			],
			2 => [
				[2, 'That I must bow so low'],
			],
		];

		$this->assertEquals($expected, array_group_by($this->numbers, 0));
	}

	public function testGroupTwoLevels()
	{
		$expected = [
			'IN' => [
				'Indianapolis' => [
					[
						'state'  => 'IN',
						'city'   => 'Indianapolis',
						'object' => 'School bus',
					],
					[
						'state'  => 'IN',
						'city'   => 'Indianapolis',
						'object' => 'Manhole',
					],
				],
				'Plainfield'   => [
					[
						'state'  => 'IN',
						'city'   => 'Plainfield',
						'object' => 'Basketball',
					],
				],
			],
			'CA' => [
				'San Diego'     => [
					[
						'state'  => 'CA',
						'city'   => 'San Diego',
						'object' => 'Light bulb',
					],
				],
				'Mountain View' => [
					[
						'state'  => 'CA',
						'city'   => 'Mountain View',
						'object' => 'Space pen',
					],
				],
			],
		];

		$this->assertEquals($expected, array_group_by($this->states, 'state', 'city'));
	}

	/**
	 * @expectedException PHPUnit_Framework_Error
	 * @expectedExceptionMessage array_group_by(): The first argument should be an array
	 */
	public function testArrayError()
	{
		array_group_by(null, null);
	}

	/**
	 * @expectedException PHPUnit_Framework_Error
	 * @expectedExceptionMessage array_group_by(): The key should be a string or an integer
	 */
	public function testKeyError()
	{
		array_group_by([], null);
	}

}
