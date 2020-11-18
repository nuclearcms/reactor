<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">

		<ContentsTitle :resource="resource" :contentTitle="contentTitle" :contentTypeName="contentTypeName" :contentTypeRoute="contentTypeRoute"/>

		<div class="paper">
			<form method="POST" action="/api/contents" @submit.prevent="requestStore('contents/' + resource.id + '/translate', 'contents.edit')" @change="form.errors.clear($event.target.name)" autocomplete="off">

				<div class="paper__body">
					<div class="paper__main">
						<FormBody :schema="schema" v-model="form" :readonly="false"/>
					</div>
					<div class="paper__side">
						<FormBody :schema="schemaSecondary" v-model="form" :readonly="false"/>
					</div>
				</div>

				<SubmitFooter :config="{icon: 'language'}" v-model="form"></SubmitFooter>
			</form>
		</div>
	</div>
</template>

<script>
import {Storer, Form, RequiresPermissions} from 'umomega-foundation'
import ContentsTitle from '../../partials/ContentsTitle'
import ContentsEditHelper from '../../mixins/ContentsEditHelper'

export default {
	mixins: [ Storer, ContentsEditHelper, RequiresPermissions ],
	components: { ContentsTitle },
	data() { return {
		titleLabel: 'hierarchy::contents.translate',
		hasOptions: false,
		breadcrumbs: [
			{to: { name: 'contents.index'}, text: this.$root.trans.get('hierarchy::contents.multiple')}
		],
		guardedBy: 'write_contents',
		form: new Form({title_translation: '', locale: ''}),
		schema: [
			{
				type: 'TextField',
				name: 'title_translation',
				label: this.$root.trans.get('validation.attributes.title'),
				options: {required: true}
			}
		],
		schemaSecondary: [
			{
				type: 'SelectField',
				name: 'locale',
				label: this.$root.trans.get('validation.attributes.locale'),
				options: { required: true, choices: {} }
			}
		]
	}},
	watch: {
		resource: function(resource) {
			var self = this

			this.breadcrumbs.push({to: { name: 'contents.edit', id: resource.id }, text: this.contentTitle })
			const availableLocales = this.$root.appLocales.filter(n => !resource.locales.includes(n))
			this.schemaSecondary[0].options.choices = availableLocales.map(function(locale) { return { value: locale, label: self.$root.trans.get('foundation::general.locale_' + locale) } })
		}
	}
}
</script>