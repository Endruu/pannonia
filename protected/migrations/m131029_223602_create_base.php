<?php

class m131029_223602_create_base extends CDbMigration
{
	public function up()
	{
		/** ------------  CREATING TABLES  ------------ **/
		/** ------------------------------------------- **/

		//Create table for album
		$this->createTable("album", array(
			"album_id" => "pk",
			"name"     => "varchar(45) NOT NULL",
			"stamp_id" => "int(11) NOT NULL",
			"public"   => "tinyint(1) NOT NULL",
		), "ENGINE=InnoDB AUTO_INCREMENT=1");

		//Create table for picture
		$this->createTable("picture", array(
			"picture_id" => "pk",
			"video"      => "tinyint(1) NOT NULL",
			"name"       => "varchar(45)",
			"take_time"  => "datetime",
			"take_place" => "varchar(45)",
			"public"     => "tinyint(1) NOT NULL",
			"album_id"   => "int(11) NOT NULL",
			"stamp_id"   => "int(11) NOT NULL",
			"extension"  => "varchar(4) NOT NULL",
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


		/** -------------  CREATING KEYS  ------------- **/
		/** ------------------------------------------- **/

		//Create keys for album
		$this->addForeignKey('album_stampid_stamp_stampid', 'album', 'stamp_id', 'stamp', 'stamp_id');

		//Create keys for picture
		$this->addForeignKey('picture_albumid_album_albumid', 'picture', 'album_id', 'album', 'album_id');
		$this->addForeignKey('picture_stampid_stamp_stampid', 'picture', 'stamp_id', 'stamp', 'stamp_id');

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

		//Drop keys for album
		$this->dropForeignKey("album_stampid_stamp_stampid", "album");

		//Drop keys for picture
		$this->dropForeignKey("picture_albumid_album_albumid", "picture");
		$this->dropForeignKey("picture_stampid_stamp_stampid", "picture");

		//Drop keys for stamp
		$this->dropForeignKey("stamp_parentid_user_userid", "stamp");
		$this->dropForeignKey("stamp_creatorid_user_userid", "stamp");
		$this->dropForeignKey("stamp_modifierid_user_userid", "stamp");

		//Drop keys for user
		$this->dropForeignKey("user_parentid_user_userid", "user");


		/** --------------  DROP TABLES  -------------- **/
		/** ------------------------------------------- **/

		$this->dropTable("album");
		$this->dropTable("picture");
		$this->dropTable("stamp");
		$this->dropTable("user");
	}

}