<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		<div class="notification is-danger">
			<h3 class="is-size-6" v-text="trans.get('reactor::general.danger_zone')"></h3>
			<p class="is-size-8" v-text="trans.get('reactor::general.danger_zone_warning')"></p>
		</div>
		<div class="paper">
			<div class="code-editor">
				<prism-editor v-model="code" :highlight="highlighter" :line-numbers="true"></prism-editor>
			</div>
			<div class="paper__footer">
				<div class="field has-addons is-pulled-right">
					<div class="control">
						<button class="button icon-only-wide is-warning" type="button" @click.prevent="saveChanges">
							<i class="icon fas fa-save"></i>
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
		titleLabel: 'reactor::general.manage_environment',
		code: ''
	}},
	mounted() {
		const self = this

		axios.get(api_url_with_token('environment'))
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
		saveChanges() {
			const self = this

			axios.put(api_url_with_token('environment'), {code: self.code})
				.then(function(response) {
					self.notifier.success(response.data.message)
				})
				.catch(function(error) { assess_error(error) })
		}
	}
};
</script>