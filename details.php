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
							'uri' => 'admin/event/create',
							'class' => 'add'
						)
					),
				)
		    )
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('events');
		$event = "
			CREATE TABLE ".$this->db->dbprefix('events')." (
				`id` bigint(20) NOT NULL AUTO_INCREMENT,
				`name` varchar(255) NOT NULL,
				`description` LONGTEXT NOT NULL,
				`start_time` TIME NOT NULL,
				`end_time` TIME NOT NULL,
				`event_date` DATETIME NOT NULL,
				`status` enum('active','inactive') NOT NULL DEFAULT 'active',
				`contact` VARCHAR(255) NOT NULL,
				`location` VARCHAR(255) NOT NULL,
				`created_on` TIMESTAMP NOT NULL,
				`modified_on` DATE NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		";
		
		$this->dbforge->drop_table('events_links');
		$links = "
			CREATE TABLE ".$this->db->dbprefix('events_links')." (
				`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
				`event_id` BIGINT(20) NOT NULL,
				`url` VARCHAR(255) NOT NULL DEFAULT '',
				`text` VARCHAR(255) NOT NULL DEFAULT '',
				`type` ENUM('default','facebook','eventbrite','mailchimp','googleplus','youtube','twitter','pinterest','pdf','svpply','yelp','foursquare','gowalla') NOT NULL DEFAULT 'default',
				`order` tinyint(5) NOT NULL,
				`created_on` TIMESTAMP NOT NULL,
				`modified_on` DATE NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		";
		
		
		$this->dbforge->drop_table('events_sponsors');
		$sponsors = "
			CREATE TABLE ".$this->db->dbprefix('events_sponsors')." (
				`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
				`event_id` BIGINT(20) NOT NULL,
				`name` VARCHAR(255) NOT NULL DEFAULT '',
				`url` VARCHAR(255) NOT NULL DEFAULT '',
				`order` TINYINT(5) NOT NULL,
				`created_on` TIMESTAMP NOT NULL,
				`modified_on` DATE NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		";

		if($this->db->query($event) && $this->db->query($links) && $this->db->query($sponsors))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		if($this->dbforge->drop_table('events') && $this->dbforge->drop_table('events_links') && $this->dbforge->drop_table('events_sponsors') )
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
		<p>Help for Event Management.</p>";
	}
}
/* End of file details.php */