<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		
		<ContentsTitle :resource="resource" :contentTitle="contentTitle" :contentTypeName="contentTypeName" :contentTypeRoute="contentTypeRoute"/>

		<tabs class="is-marginless" :tabs="[
			{route: 'contents.edit', label: 'hierarchy::contents.single', active: true},
			{route: 'contents.settings', label: 'hierarchy::contents.settings', active: false},
			{route: 'contents.statistics', label: 'hierarchy::contents.statistics', active: false},
		]"></tabs>

		<div class="paper">
			<ContentsHeader :permission="$can('write_contents')" :resource="resource" :editingLocale="editingLocale" :errors="form.errors" :canHaveMoreTranslations="canHaveMoreTranslations" :canDeleteCurrentTranslation="canDeleteCurrentTranslation" :contentId="contentId"/>

			<form method="POST" action="/api/contents" @submit.prevent="requestUpdate('contents')" @keydown="clearError($event.target.name)" autocomplete="off">
				
				<div class="paper__body">
					<div class="paper__main">
						<div v-for="locale in resource.locales">
							<FormBody :class="locale == editingLocale ? '' : 'is-sr-only'" :schema="schema" v-model="form" :readonly="!$can('write_contents') || resource.is_locked == 1" :translatable="true" :translatableFields="translatableFields" :locale="locale"/>
						</div>
					</div>
					<div class="paper__side">
						<h3 class="is-size-4 has-color-grey mb-sm" v-text="trans.get('hierarchy::contents.seo_and_search')"></h3>
						<div v-for="locale in resource.locales">
							<FormBody :class="locale == editingLocale ? '' : 'is-sr-only'" :schema="schemaSecondary" v-model="form" :readonly="!$can('write_contents') || resource.is_locked == 1" :translatable="true" :translatableFields="secondaryTranslatableFields" :locale="locale"/>
						</div>
					</div>
				</div>

				<SubmitFooter v-if="$can('write_contents') && resource.is_locked == 0" :config="{icon: 'save'}" v-model="form">
					<div class="control" v-if="contentStatus < 50">
						<button class="button icon-only is-warning" type="submit" @click.prevent="saveAndPublish" :disabled="form.errors.anyErrors">
							<i class="icon fas fa-check"></i>
						</button>
					</div>
				</SubmitFooter>
				<div class="paper__footer" v-else>
					<div class="field has-addons is-pulled-right">
						<div class="control">
							<button class="button icon-only-wide is-dark" type="submit">
								<i class="icon fas fa-lock"></i>
							</button>
						</div>
					</div>
				</div>
				
			</form>
		</div>
	</div>
</template>

<script>
import {Updater, Tabs, Form, RequiresPermissions, Translatable} from 'umomega-foundation'
import ContentsTitle from '../../partials/ContentsTitle'
import ContentsHeader from '../../partials/ContentsHeader'
import ContentsEditHelper from '../../mixins/ContentsEditHelper'

export default {
	mixins: [ Updater, RequiresPermissions, Translatable, ContentsEditHelper ],
	components: { Tabs, ContentsHeader, ContentsTitle },
	data() { return {
		titleLabel: 'hierarchy::contents.edit',
		hasOptions: true,
		breadcrumbs: [
			{to: { name: 'contents.index'}, text: this.$root.trans.get('hierarchy::contents.multiple')}
		],
		guardedBy: 'read_contents',
		translatableFields: ['title'],
		secondaryTranslatableFields: ['meta_title', 'meta_description', 'meta_author', 'keywords'],
		form: new Form({content_type_id: '', title: '', meta_title: '', meta_description: '', meta_author: '', keywords: '', status: 100}),
		schema: [
			{
				type: 'TextField',
				name: 'title',
				label: this.$root.trans.get('validation.attributes.title'),
				options: {required: true}
			}
		],
		schemaSecondary: [
			{
				type: 'TextField',
				name: 'meta_title',
				label: this.$root.trans.get('validation.attributes.meta_title')
			},
			{
				type: 'TextareaField',
				name: 'meta_description',
				label: this.$root.trans.get('validation.attributes.meta_description')
			},
			{
				type: 'TextareaField',
				name: 'keywords',
				label: this.$root.trans.get('validation.attributes.keywords')
			},
			{
				type: 'TextField',
				name: 'meta_author',
				label: this.$root.trans.get('validation.attributes.meta_author')
			}
		]
	}},
	watch: {
		$route(to, from) {
			if(from.params.id != to.params.id) this.loadResource()
		}
	},
	methods: {
		saveAndPublish() {
			this.form.status = 50
			this.requestUpdate('contents')
		}
	},
	mounted() {
		const self = this

		Event.$off('resource-loaded')
		Event.$on('resource-loaded', function(data) {
			data.schema.schema.forEach(function(field, i) {
				self.form.originalData[field.name] = {}
				self.translatableFields.push(field.name)
				self.form.populate(data.extensions)
				self.schema.push(field)
			})
		})
	}
}
</script>