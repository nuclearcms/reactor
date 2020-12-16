<template>
	<header class="header">
		<nav class="breadcrumb is-marginless">
			<ul>
				<li class="header-breadcrumb"><router-link :to="{ name: 'dashboard.overview' }" exact>Nuclear</router-link></li>
				<li class="header-breadcrumb" v-for="breadcrumb in breadcrumbs"><router-link :to="breadcrumb.to" v-text="breadcrumb.text"/></li>
			</ul>
		</nav>
		<h1 class="page-heading mb-xxl" v-text="pagetitle"></h1>
	</header>
</template>

<script>
export default {
	data() {
		return {
			pagetitle: '',
			breadcrumbs: []
		}
	},
	created() {
		var self = this;

		Event.$on('page-changed', function(data) {
			self.pagetitle = data.title
			self.breadcrumbs = data.breadcrumbs || {}
		});
	}
}
</script>