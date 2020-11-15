<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		<div class="paper">
			<div class="code-editor is-size-9">
				<prism-editor v-model="code" :highlight="highlighter" :line-numbers="true" :readonly="true"></prism-editor>
			</div>
			<div class="paper__footer">
				<div class="field has-addons is-pulled-right">
					<div class="control">
						<button class="button icon-only-wide is-danger" type="button" @click.prevent="clearLogs">
							<i class="icon fas fa-broom"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import {View, assess_error} from 'umomega-foundation'
import {PrismEditor} from 'vue-prism-editor'
import 'vue-prism-editor/dist/prismeditor.min.css'
import {highlight, languages} from 'prismjs/components/prism-core'
import 'prismjs/components/prism-clike'
import 'prismjs/components/prism-javascript'
import 'prismjs/themes/prism-tomorrow.css'

export default {
	mixins: [ View ],
	components: { PrismEditor },
	data() { return {
		titleLabel: 'reactor::general.manage_logs',
		code: ''
	}},
	mounted() {
		const self = this

		axios.get(api_url_with_token('logs'))
			.then(function(response) {
				self.code = response.data
				self.isLoaded = true
			})
			.catch(function(error) { assess_error(error) })

		
	},
	methods: {
		highlighter(code) {
    		return highlight(code, languages.js);
		},
		clearLogs() {
			const self = this

			axios.delete(api_url_with_token('logs'))
				.then(function(response) {
					self.code = response.data.log
					self.notifier.success(response.data.message)
				})
				.catch(function(error) { assess_error(error) })
		}
	}
};
</script>