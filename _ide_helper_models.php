<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Device
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $location_id
 * @property int $hidden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Location $location
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $team
 * @property-read int|null $team_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUserId($value)
 */
	class Device extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $name
 * @property int $team_id
 * @property int $user_id
 * @property int $hidden
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|Location[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @property-read int|null $devices_count
 * @property-read Location|null $parent
 * @property-read \App\Models\Team $team
 * @property-read \App\Models\User $user
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location ancestorsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location ancestorsOf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location applyNestedSetScope(?string $table = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location countErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location defaultOrder(string $dir = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location descendantsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location fixSubtree($root)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location fixTree($root = null)
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location getNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location getPlainNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location getTotalErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location hasChildren()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location hasParent()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location isBroken()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location leaves(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location makeGap(int $cut, int $height)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location moveNode($key, $position)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location orWhereDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location orWhereNodeBetween($values)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location orWhereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location query()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location rebuildSubtree($root, array $data, $delete = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location rebuildTree(array $data, $delete = false, $root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location reversed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location root(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereAncestorOrSelf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereCreatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereHidden($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereIsAfter($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereIsBefore($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereIsLeaf()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereIsRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereLft($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereName($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereNodeBetween($values, $boolean = 'and', $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereParentId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereRgt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereTeamId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereUpdatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location whereUserId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location withDepth(string $as = 'depth')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Location withoutRoot()
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Membership
 *
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Membership newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Membership newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Membership query()
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUserId($value)
 */
	class Membership extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Team
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property bool $personal_team
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @property-read int|null $devices_count
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Location[] $locations
 * @property-read int|null $locations_count
 * @property-read \App\Models\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TeamInvitation[] $teamInvitations
 * @property-read int|null $team_invitations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\TeamFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team wherePersonalTeam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUserId($value)
 */
	class Team extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TeamInvitation
 *
 * @property int $id
 * @property int $team_id
 * @property string $email
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team $team
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereUpdatedAt($value)
 */
	class TeamInvitation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team|null $currentTeam
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @property-read int|null $devices_count
 * @property-read string $profile_photo_url
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Location[] $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

