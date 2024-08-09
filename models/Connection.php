<?php

namespace app\models;

use yii\db\ActiveRecord;

class Connection extends ActiveRecord {
    public static function tableName() {
        return 'connection';
    }
}