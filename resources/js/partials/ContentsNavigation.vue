<template>
	<nav class="contents-navigation">
		<h2 class="contents-navigation__flap is-uppercase"><span v-text="trans.get('reactor::general.contents')"></span></h2>
		<router-link v-if="$can('write_contents')" :to="{ name: 'contents.create' }" class="contents-navigation__new"><i class="icon fas fa-plus"></i></router-link>
		
		<div class="field mb-md">
			<div class="control has-icons-left">
				<input type="search" class="input" name="q" :placeholder="trans.get('foundation::general.search_for')">
				<span class="icon is-small is-left">
					<i class="fas fa-search"></i>
				</span>
			</div>
		</div>

		<div class="contents-navigation__locales"></div>
	</nav>
</template>

<script>
import {RequiresPermissions} from 'umomega-foundation'

export default {
	mixins: [ RequiresPermissions ]
}
</script>