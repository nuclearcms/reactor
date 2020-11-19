<script>
import {View, Shower, FormBody, SubmitFooter} from 'umomega-foundation'

export default {
	mixins: [ View, Shower ],
	components: { FormBody, SubmitFooter },
	data() { return {
		showRoute: 'contents',
	}},
	computed: {
		contentTitle() {
			return this.resource.title != undefined ? this.resource.title[this.$root.appLocale] : ''
		},
		contentId() {
			return this.resource.id != undefined ? this.resource.id : 0
		},
		contentTypeRoute() {
			return this.resource.id != undefined ? { name: 'contenttypes.edit', params: { id: this.resource.contentType.id }} : { name: 'contenttypes.edit', params: { id: 0 } }
		},
		contentTypeName() {
			return this.resource.id != undefined ? this.resource.contentType.name : ''
		},
		contentStatus() {
			return this.resource.id != undefined ? this.resource.status : 100
		},
		contentTaggable() {
			return this.resource.id != undefined ? this.resource.contentType.is_taggable : false
		}
	},
	mounted() {
		const self = this

		Event.$off('content-state-changed')
		Event.$on('content-state-changed', function() {
			self.loadResource()
		})
	}
}
</script>