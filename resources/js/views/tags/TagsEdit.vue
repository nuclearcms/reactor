<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		<div class="has-text-centered mb-lg">
			<p class="is-size-4" v-text="tagName"></p>
			<p class="is-size-8 has-color-grey-darker" v-text="tagSlug"></p>
		</div>

		<tabs class="is-marginless" :tabs="[
			{route: 'tags.edit', label: 'tags::tags.single', active: true},
			{route: 'tags.contents', label: 'hierarchy::contents.multiple', active: false}
		]"></tabs>

		<div class="paper">
			<PaperHeader :permission="$can('write_tags')" :resource="resource" :editingLocale="editingLocale" :errors="form.errors">
				<router-link v-if="canHaveMoreTranslations" class="dropdown-item" :to="{ name: 'tags.translate', params: {id: this.tagId} }">
					<i class="icon fas fa-language has-color-grey-darker"></i> {{ trans.get('tags::tags.translate') }}
				</router-link>
				<a href="#" v-if="canDeleteCurrentTranslation" class="dropdown-item" @click.prevent="openDeleteModal({ bulk: false, route: 'tags/' + tagId + '/translate/' + editingLocale})">
					<i class="icon fas fa-minus has-color-grey-darker"></i> {{ trans.get('foundation::general.delete_translation') }}
				</a>
				<a href="#" class="dropdown-item has-color-danger" @click.prevent="openDeleteModal({ bulk: false, route: 'tags/' + tagId})">
					<i class="icon fas fa-trash"></i> {{ trans.get('tags::tags.delete') }}
				</a>
			</PaperHeader>
			
			<form method="POST" action="/api/tags" @submit.prevent="requestUpdate('tags')" @keydown="clearError($event.target.name)" autocomplete="off">
				
				<div class="paper__body">
					<div class="paper__main">
						<div v-for="locale in resource.locales">
							<FormBody :class="locale == editingLocale ? '' : 'is-sr-only'" :schema="schema" v-model="form" :readonly="!$can('write_tags')" :translatable="true" :translatableFields="translatableFields" :locale="locale"/>
						</div>
					</div>
					<div class="paper__side">
						<FormBody :schema="schemaSecondary" v-model="form" :readonly="!$can('write_tags')"/>
					</div>
				</div>

				<SubmitFooter v-if="$can('write_tags')" :config="{icon: 'save'}" v-model="form"></SubmitFooter>

			</form>
		</div>
	</div>
</template>

<script>
import {Updater, Tabs, Form, RequiresPermissions, PaperHeader, Translatable} from 'umomega-foundation'
import {TagsEditHelper} from 'umomega-tags'

export default {
	mixins: [ Updater, RequiresPermissions, Translatable, TagsEditHelper ],
	components: { Tabs, PaperHeader },
	data() { return {
		titleLabel: 'tags::tags.edit',
		hasOptions: true,
		breadcrumbs: [
			{to: { name: 'tags.index'}, text: this.$root.trans.get('tags::tags.multiple')}
		],
		guardedBy: 'read_tags',
		translatableFields: ['name', 'slug'],
		form: new Form({name: '', slug: '', type: ''}),
		schema: [
			{
				type: 'TextField',
				name: 'name',
				label: this.$root.trans.get('validation.attributes.name'),
				options: {required: true}
			},
			{
				type: 'TextField',
				name: 'slug',
				label: this.$root.trans.get('validation.attributes.slug')
			}
		],
		schemaSecondary: [
			{
				type: 'TextField',
				name: 'type',
				label: this.$root.trans.get('validation.attributes.type')
			}
		]
	}}
}
</script>