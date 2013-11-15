<?php

class m131029_223602_create_base extends CDbMigration
{
	public function up()
	{
		/** ------------  CREATING TABLES  ------------ **/
		/** ------------------------------------------- **/

		//Create table for ai_info
		$this->createTable("ai_info", array(
			"ai_info_id"  => "pk",
			"take_time"   => "datetime",
			"take_place"  => "varchar(120)",
			"take_author" => "varchar(120)",
		), "ENGINE=InnoDB AUTO_INCREMENT=1");

		//Create table for ai_log_main
		$this->createTable("ai_log_main", array(
			"ai_log_main_id" => "pk",
			"start_time"     => "int(11)",
			"duration"       => "int(11)",
			"peak_memory"    => "int(11)",
			"user_id"        => "int(11)",
		), "ENGINE=InnoDB AUTO_INCREMENT=1");

		//Create table for ai_log_sub
		$this->createTable("ai_log_sub", array(
			"ai_log_sub_id"  => "pk",
			"level"          => "varchar(128)",
			"category"       => "varchar(128)",
			"logtime"        => "int(11)",
			"msg"            => "text",
			"ai_log_main_id" => "int(11)",
			"iid"            => "int(11)",
			"aid"            => "int(11)",
		), "ENGINE=InnoDB AUTO_INCREMENT=1");

		//Create table for album
		$this->createTable("album", array(
			"album_id"   => "pk",
			"name"       => "varchar(45) NOT NULL",
			"stamp_id"   => "int(11) NOT NULL",
			"public"     => "tinyint(1) NOT NULL",
			"ai_info_id" => "int(11)",
			"deleted"    => "datetime",
		), "ENGINE=InnoDB AUTO_INCREMENT=1");

		//Create table for image
		$this->createTable("image", array(
			"image_id"      => "pk",
			"name"          => "varchar(120)",
			"public"        => "tinyint(1) NOT NULL",
			"album_id"      => "int(11) NOT NULL",
			"stamp_id"      => "int(11) NOT NULL",
			"extension"     => "varchar(3) NOT NULL",
			"hash"          => "char(32)",
			"original_name" => "varchar(120)",
			"ai_info_id"    => "int(11)",
			"deleted"       => "datetime",
		), "ENGINE=InnoDB AUTO_INCREMENT=1");

		//Create table for stamp
		$this->createTable("stamp", array(
			"stamp_id"    => "pk",
			"created_at"  => "datetime NOT NULL",
			"modified_at" => "datetime",
			"creator_id"  => "int(11) NOT NULL",
			"modifier_id" => "int(11)",
			"parent_id"   => "int(11)",
			"lectored_at" => "datetime",
		), "ENGINE=InnoDB AUTO_INCREMENT=1");

		//Create table for user
		$this->createTable("user", array(
			"user_id"    => "pk",
			"name"       => "varchar(77) NOT NULL",
			"nick"       => "varchar(15) NOT NULL",
			"parent_id"  => "int(11)",
			"created_at" => "datetime NOT NULL",
		), "ENGINE=InnoDB AUTO_INCREMENT=1");

		// Add superuser:
		$this->insert( "user", array(
			"user_id"    => 1,
			"name"       => "sysAdmin",
			"nick"       => "sysAdmin",
			"parent_id"  => "1",
			"created_at" => "NOW()",
		));
		
		
		/** -------------  CREATING KEYS  ------------- **/
		/** ------------------------------------------- **/

		//Create keys for ai_log_main
		$this->addForeignKey('ailogmain_userid_user_userid', 'ai_log_main', 'user_id', 'user', 'user_id');

		//Create keys for ai_log_sub
		$this->addForeignKey('ailogsub_ailogmainid_ailogmain_ailogmainid', 'ai_log_sub', 'ai_log_main_id', 'ai_log_main', 'ai_log_main_id');
		$this->addForeignKey('ailogsub_iid_image_imageid', 'ai_log_sub', 'iid', 'image', 'image_id');
		$this->addForeignKey('ailogsub_aid_album_albumid', 'ai_log_sub', 'aid', 'album', 'album_id');

		//Create keys for album
		$this->addForeignKey('album_stampid_stamp_stampid', 'album', 'stamp_id', 'stamp', 'stamp_id');
		$this->addForeignKey('album_aiinfoid_aiinfo_aiinfoid', 'album', 'ai_info_id', 'ai_info', 'ai_info_id');

		//Create keys for image
		$this->addForeignKey('image_albumid_album_albumid', 'image', 'album_id', 'album', 'album_id');
		$this->addForeignKey('image_stampid_stamp_stampid', 'image', 'stamp_id', 'stamp', 'stamp_id');
		$this->addForeignKey('image_aiinfoid_aiinfo_aiinfoid', 'image', 'ai_info_id', 'ai_info', 'ai_info_id');

		//Create keys for stamp
		$this->addForeignKey('stamp_parentid_user_userid', 'stamp', 'parent_id', 'user', 'user_id');
		$this->addForeignKey('stamp_creatorid_user_userid', 'stamp', 'creator_id', 'user', 'user_id');
		$this->addForeignKey('stamp_modifierid_user_userid', 'stamp', 'modifier_id', 'user', 'user_id');

		//Create keys for user
		$this->addForeignKey('user_parentid_user_userid', 'user', 'parent_id', 'user', 'user_id');
	}

	public function down()
	{
		/** ---------------  DROP KEYS  --------------- **/
		/** ------------------------------------------- **/

		//Drop keys for ai_log_main
		$this->dropForeignKey("ailogmain_userid_user_userid", "ai_log_main");

		//Drop keys for ai_log_sub
		$this->dropForeignKey("ailogsub_ailogmainid_ailogmain_ailogmainid", "ai_log_sub");
		$this->dropForeignKey("ailogsub_iid_image_imageid", "ai_log_sub");
		$this->dropForeignKey("ailogsub_aid_album_albumid", "ai_log_sub");

		//Drop keys for album
		$this->dropForeignKey("album_stampid_stamp_stampid", "album");
		$this->dropForeignKey("album_aiinfoid_aiinfo_aiinfoid", "album");

		//Drop keys for image
		$this->dropForeignKey("image_albumid_album_albumid", "image");
		$this->dropForeignKey("image_stampid_stamp_stampid", "image");
		$this->dropForeignKey("image_aiinfoid_aiinfo_aiinfoid", "image");

		//Drop keys for stamp
		$this->dropForeignKey("stamp_parentid_user_userid", "stamp");
		$this->dropForeignKey("stamp_creatorid_user_userid", "stamp");
		$this->dropForeignKey("stamp_modifierid_user_userid", "stamp");

		//Drop keys for user
		$this->dropForeignKey("user_parentid_user_userid", "user");


		/** --------------  DROP TABLES  -------------- **/
		/** ------------------------------------------- **/

		$this->dropTable("ai_info");
		$this->dropTable("ai_log_main");
		$this->dropTable("ai_log_sub");
		$this->dropTable("album");
		$this->dropTable("image");
		$this->dropTable("stamp");
		$this->dropTable("user");
	}

}