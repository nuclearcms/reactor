<template>
	<div :class="isLoaded ? 'paper reveal is-loaded' : 'paper reveal'">
		<div class="paper__main">
			<section class="maintenance-section mb-xxl" v-for="section in sections">
				<h2 class="is-size-4 has-color-blue" v-text="trans.get('reactor::general.section_' + section.title)"></h2>
				<p class="mb-lg" v-text="trans.get('reactor::general.section_' + section.title + '_desc')">
				<div v-for="command in section.commands" class="mb-xs maintenance-command">
					<button class="button is-primary is-uppercase" type="button" @click.prevent="executeCommand(command)" v-text="command"></button>
					<p class="is-size-7 has-color-grey-darker" v-text="trans.get('reactor::general.maintenance_' + command)"></p>
				</div>
			</section>
		</div>
	</div>
</template>

<script>
import {View, assess_error} from 'umomega-foundation'

export default {
	mixins: [ View ],
	data() { return {
		titleLabel: 'reactor::general.maintain_reactor',
		sections: [
			{ title: 'maintenance', commands: ['down'] },
			{ title: 'performance', commands: ['optimize', 'route_cache', 'config_cache', 'view_cache', 'package_discover'] },
			{ title: 'cleanup', commands: ['route_clear', 'cache_clear', 'config_clear', 'view_clear', 'optimize_clear', 'clear-compiled', 'activitylog_clean', 'permission_cache-reset', 'telescope_clear']},
			{ title: 'seo', commands: ['sitemap_generate']},
			{ title: 'security', commands: ['key_generate']}
		]
	}},
	mounted() {
		const self = this

		setTimeout(function() {
			self.isLoaded = true
		})
	},
	methods: {
		executeCommand(command) {
			const self = this

			axios.put(api_url_with_token('maintenance/' + command))
				.then(function(response) {
					if(response.data.success) {
						self.notifier.success(response.data.message)
					} else {
						self.notifier.danger(response.data.message)
					}
				})
				.catch(function(error) { assess_error(error) })
		}
	}
};
</script>