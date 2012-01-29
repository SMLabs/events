<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Event extends Module {

	public $version = '1.1';

	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Events',
				'en' => 'Events',
				'de' => 'Events',
				'nl' => 'Events',
				'fr' => 'Events',
				'zh' => 'Events',
				'it' => 'Events',
				'ru' => 'Events',
				'ar' => 'Events',
				'pt' => 'Events',
				'cs' => 'Events',
				'es' => 'Events',
				'fi' => 'Events',
				'lt' => 'Events'
			),
			'description' => array(
				'sl' => 'Manage Your Events.',
				'en' => 'Manage Your Events.',
				'de' => 'Manage Your Events.',
				'nl' => 'Manage Your Events.',
				'fr' => 'Manage Your Events.',
				'zh' => 'Manage Your Events.',
				'it' => 'Manage Your Events.',
				'ru' => 'Manage Your Events.',
				'ar' => 'Manage Your Events.',
				'pt' => 'Manage Your Events.',
			    'cs' => 'Manage Your Events.',
				'es' => 'Manage Your Events.',
				'fi' => 'Manage Your Events.',
				'lt' => 'Manage Your Events.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content',
			
			'sections' => array(
			    'events' => array(
				    'name' => 'events_admin_section_title',
				    'uri' => 'admin/event',
				    'shortcuts' => array(
						array(
							'name' => 'events_admin_section_title',
							'uri' => 'admin/event/',
							'class' => ''
						),
						array(
							'name' => 'events_admin_shortcut_add',
							'uri' => 'admin/event/create_event',
							'class' => 'add'
						)
					),
				)
		    )
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('dch_events');

		$dch_event = "
			CREATE TABLE ".$this->db->dbprefix('dch_events')." (
				`id` bigint(20) NOT NULL AUTO_INCREMENT,
				`name` varchar(255) NOT NULL,
				`description` LONGTEXT NOT NULL,
				`sponsors` VARCHAR( 255 ) NOT NULL,
				`facebook_event_url` VARCHAR( 255 ) NOT NULL,
				`eventbrite_event_url` VARCHAR( 255 ) NOT NULL,
				`start_time` TIME NOT NULL,
				`end_time` TIME NOT NULL,
				`event_date` DATETIME NOT NULL,
				`status` enum('Active','Deactive') NOT NULL DEFAULT 'Active',
				`created_on` TIMESTAMP NOT NULL,
				`modified_on` DATE NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		";

		if($this->db->query($dch_event))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		if($this->dbforge->drop_table('dch_events'))
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "<h4>Overview</h4>
		<p>This is event management module only for DCH.</p>";
	}
}
/* End of file details.php */