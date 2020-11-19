<template>
	<nav class="tools-navigation">

        <Dropdown v-if="$can('read_contents')">
            <template v-slot:dropdown-button>
                <i class="icon fas fa-code-branch"></i>
            </template>
            <template v-slot:dropdown-label>{{ trans.get('hierarchy::contents.multiple') }}</template>
            <router-link :to="{ name: 'contents.index' }" class="dropdown-item">
                <i class="icon fas fa-align-justify has-color-grey-darker"></i> {{ trans.get('hierarchy::contents.manage') }}
            </router-link>
            <hr class="dropdown-divider">
            <router-link :to="{ name: 'contents.index', query: { f: 'unpublished'} }" class="dropdown-item">
                <i class="icon fas fa-times has-color-grey-darker"></i> {{ trans.get('hierarchy::contents.c_unpublished') }}
            </router-link>
            <router-link :to="{ name: 'contents.index', query: { f: 'locked'} }" class="dropdown-item">
                <i class="icon fas fa-lock has-color-grey-darker"></i> {{ trans.get('hierarchy::contents.c_locked') }}
            </router-link>
            <router-link :to="{ name: 'contents.index', query: { f: 'invisible'} }" class="dropdown-item">
                <i class="icon fas fa-eye-slash has-color-grey-darker"></i> {{ trans.get('hierarchy::contents.c_invisible') }}
            </router-link>
        </Dropdown>

        <Dropdown v-if="$can('read_media')">
            <template v-slot:dropdown-button><i class="icon fas fa-folder"></i></template>
            <template v-slot:dropdown-label>{{ trans.get('media::media.multiple') }}</template>
            <router-link :to="{ name: 'media.index' }" class="dropdown-item">
                <i class="icon fas fa-photo-video has-color-grey-darker"></i> {{ trans.get('media::media.manage') }}
            </router-link>
            <router-link :to="{ name: 'media.upload' }" class="dropdown-item">
                <i class="icon fas fa-file-upload has-color-grey-darker"></i> {{ trans.get('media::media.upload') }}
            </router-link>
            <router-link :to="{ name: 'media.embed' }" class="dropdown-item">
                <i class="icon fas fa-file-code has-color-grey-darker"></i> {{ trans.get('media::media.embed') }}
            </router-link>
        </Dropdown>


        <Dropdown v-if="$can('read_tags')">
            <template v-slot:dropdown-button><i class="icon fas fa-tags"></i></template>
            <template v-slot:dropdown-label>{{ trans.get('tags::tags.multiple') }}</template>
            <router-link :to="{ name: 'tags.index' }" class="dropdown-item">
                <i class="icon fas fa-tags has-color-grey-darker"></i> {{ trans.get('tags::tags.manage') }}
            </router-link>
            <router-link :to="{ name: 'tags.create' }" v-if="$can('write_users')" class="dropdown-item">
                <i class="icon fas fa-plus has-color-grey-darker"></i> {{ trans.get('tags::tags.create') }}
            </router-link>
        </Dropdown>


        <Dropdown v-if="$can('read_users')">
            <template v-slot:dropdown-button><i class="icon fas fa-users"></i></template>
            <template v-slot:dropdown-label>{{ trans.get('auth::users.multiple') }}</template>
            <router-link :to="{ name: 'users.index' }" class="dropdown-item">
                <i class="icon fas fa-users has-color-grey-darker"></i> {{ trans.get('auth::users.manage') }}
            </router-link>
            <router-link :to="{ name: 'users.create' }" v-if="$can('write_users')" class="dropdown-item">
                <i class="icon fas fa-user-plus has-color-grey-darker"></i> {{ trans.get('auth::users.create') }}
            </router-link>
            <hr class="dropdown-divider" v-if="$can('rw_permissions')">
            <div class="dropdown-label" v-if="$can('rw_permissions')">{{ trans.get('auth::users.roles_and_permissions') }}</div>
            <router-link :to="{ name: 'roles.index' }" v-if="$can('rw_permissions')" class="dropdown-item">
                <i class="icon fas fa-user-tag has-color-grey-darker"></i> {{ trans.get('auth::roles.manage') }}
            </router-link>
            <router-link :to="{ name: 'permissions.index' }" v-if="$can('rw_permissions')" class="dropdown-item">
                <i class="icon fas fa-user-check has-color-grey-darker"></i> {{ trans.get('auth::permissions.manage') }}
            </router-link>
        </Dropdown>


        <Dropdown v-if="$can('maintain_reactor') || $can('read_contenttypes') || $can('rw_environment') || $can('rw_logs')">
            <template v-slot:dropdown-button><i class="icon fas fa-tools"></i></template>
            <template v-slot:dropdown-label>{{ trans.get('reactor::general.construction_maintenance') }}</template>
            <router-link v-if="$can('read_contenttypes')" :to="{ name: 'contenttypes.index' }" class="dropdown-item">
                <i class="icon fas fa-shapes has-color-grey-darker"></i> {{ trans.get('hierarchy::contenttypes.manage') }}
            </router-link>
            <hr v-if="$can('read_contenttypes') && ($can('maintain_reactor') || $can('rw_environment') || $can('rw_logs'))" class="dropdown-divider">
            <router-link v-if="$can('maintain_reactor')" :to="{ name: 'maintenance' }" class="dropdown-item">
                <i class="icon fas fa-wrench has-color-grey-darker"></i> {{ trans.get('reactor::general.maintenance') }}
            </router-link>
            <router-link v-if="$can('rw_environment')" :to="{ name: 'environment' }" class="dropdown-item">
                <i class="icon fas fa-cogs has-color-grey-darker"></i> {{ trans.get('reactor::general.environment_variables') }}
            </router-link>
            <router-link v-if="$can('rw_logs')" :to="{ name: 'logs' }" class="dropdown-item">
                <i class="icon fas fa-exclamation-triangle has-color-grey-darker"></i> {{ trans.get('reactor::general.manage_logs') }}
            </router-link>
        </Dropdown>


		<Dropdown>
			<template v-slot:dropdown-button>
				<img :src="store.user.gravatar" alt="Avatar" class="tools-navigation__avatar"><span class="tools-navigation__initials" v-text="store.user.initials"></span>
			</template>
			<template v-slot:dropdown-label>{{ store.user.full_name }}</template>
			<router-link :to="{ name: 'profile.edit' }" class="dropdown-item">
                <i class="icon fas fa-user-circle has-color-grey-darker"></i>
                {{ trans.get('auth::users.update_profile') }}
            </router-link>
            <router-link :to="{ name: 'profile.password' }" class="dropdown-item">
                <i class="icon fas fa-lock has-color-grey-darker"></i>
                {{ trans.get('auth::users.change_password') }}
            </router-link>
            <hr class="dropdown-divider">
            <a href="#" class="dropdown-item" id="logout-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            	<i class="icon fas fa-sign-out-alt has-color-grey-darker"></i>
            	{{ trans.get('auth::auth.logout') }}
            </a>
		</Dropdown>

	</nav>
</template>

<script>
import {Dropdown, Permissions} from 'umomega-foundation';

export default {
	components: { Dropdown },
    mixins: [ Permissions ]
}
</script>