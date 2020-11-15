<template>
	<nav class="contents-navigation">
		<h2 class="contents-navigation__flap is-uppercase"><span v-text="trans.get('reactor::general.contents')"></span></h2>
		<a class="contents-navigation__new"><i class="icon fas fa-plus"></i></a>
		
		<div class="field mb-md">
			<div class="control has-icons-left">
				<input type="search" class="input" name="q" placeholder="Search nodes (change)">
				<span class="icon is-small is-left">
					<i class="fas fa-search"></i>
				</span>
			</div>
		</div>

		<div class="contents-navigation__locales"></div>
	</nav>
</template>

<script>
export default {}
</script>