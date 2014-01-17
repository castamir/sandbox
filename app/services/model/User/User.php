<?php

namespace Model\Tables;

use Model\BaseEntity;
use DateTime;
use LeanMapper\Exception\InvalidArgumentException;
use LeanMapper\Filtering;
use Nette\Utils\Strings;

/**
 * @property string $username
 * @property string $password
 * @property Role[] $role m:hasMany
 * @property string|NULL $email
 * @property string|NULL $skype
 * @property string|NULL $phone
 * @property int|NULL $gameID (game_id)
 * @property DateTime|NULL $ekoPrepocet (eko_rec) m:passThru(toString|)
 * @property DateTime|NULL $vojPrepocet (army_rec) m:passThru(toString|)
 */
class User extends BaseEntity
{

	protected function toString(DateTime $dateTime = NULL)
	{
		return $dateTime ? $dateTime->format("H:i") : NULL;
	}

}

class InvalidPhoneFormatException extends \Exception {

}
