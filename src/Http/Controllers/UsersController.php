<?php

namespace Nuclear\Reactor\Http\Controllers;

use Nuclear\Reactor\Http\Requests\UpdateUser;
use Nuclear\Reactor\Auth\User;
use Umomega\Auth\Http\Controllers\UsersController as BaseUsersController;

class UsersController extends BaseUsersController
{
	
	/**
	 * Retrieves the user information
	 *
	 * @param User $user
	 * @return json
	 */
	public function showExtended(User $user)
	{
		\Log::info($user);
		return $user;
	}

    /**
	 * Updates the user
	 *
	 * @param UpdateUser $request
	 * @param User $user
	 * @return json
	 */
	public function updateWithExtensions(UpdateUser $request, User $user)
	{
		$validated = $request->validated();

		$user->updateContents($validated['contents_list']);

		// Let the parent do its thing
		$response = $this->update($request, $user);

        return $response;
    }

}