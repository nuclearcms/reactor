<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		
		<ContentsTitle :resource="resource" :contentTitle="contentTitle" :contentTypeName="contentTypeName" :contentTypeRoute="contentTypeRoute"/>

		<tabs class="is-marginless" :tabs="[
			{route: 'contents.edit', label: 'hierarchy::contents.single', active: false},
			{route: 'contents.settings', label: 'hierarchy::contents.settings', active: true},
			{route: 'contents.statistics', label: 'hierarchy::contents.statistics', active: false},
		]"></tabs>

		<div class="paper">
			<ContentsHeader :permission="$can('write_contents')" :resource="resource" :editingLocale="null" :errors="form.errors" :canHaveMoreTranslations="canHaveMoreTranslations" :canDeleteCurrentTranslation="false" :contentId="contentId"/>

			<form method="POST" action="/api/contents" @submit.prevent="requestUpdate('contents', '/settings')" @keydown="clearError($event.target.name)" autocomplete="off">
				<div class="paper__body paper__body--noside">
					<div class="paper__main">
						<FormBody :schema="schema" v-model="form" :readonly="!$can('write_contents') || resource.is_locked == 1"/>
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
		titleLabel: 'hierarchy::contents.edit_settings',
		hasOptions: true,
		breadcrumbs: [
			{to: { name: 'contents.index'}, text: this.$root.trans.get('hierarchy::contents.multiple')}
		],
		guardedBy: 'read_contents',
		form: new Form({ is_visible: true, is_sterile: false, is_locked: false, status: 30, hides_children: false, priority: 1, published_at: null, children_display_mode: 'list', status: 100 }),
		schema: [
			[
				{
					type: 'CheckboxField',
					name: 'is_visible',
					label: this.$root.trans.get('validation.attributes.is_visible'),
					options: {required: true}
				},
				{
					type: 'CheckboxField',
					name: 'is_sterile',
					label: this.$root.trans.get('validation.attributes.is_sterile'),
					options: {required: true}
				},
				{
					type: 'CheckboxField',
					name: 'is_locked',
					label: this.$root.trans.get('validation.attributes.is_locked'),
					options: {required: true}
				},
				{
					type: 'NumberField',
					name: 'priority',
					label: this.$root.trans.get('validation.attributes.priority'),
					options: {required: true}
				}
			],
			[
				{
					type: 'DatetimeField',
					name: 'published_at',
					label: this.$root.trans.get('validation.attributes.published_at'),
					options: {required: true}
				},
				{
					type: 'SelectField',
					name: 'status',
					label: this.$root.trans.get('validation.attributes.status'),
					options: {
						required: true,
						choices: [
							{ value: 30, label: this.$root.trans.get('hierarchy::contents.status_30')},
							{ value: 40, label: this.$root.trans.get('hierarchy::contents.status_40')},
							{ value: 50, label: this.$root.trans.get('hierarchy::contents.status_50')},
							{ value: 60, label: this.$root.trans.get('hierarchy::contents.status_60')}
						]
					}
				}
			],
			[
				{
					type: 'CheckboxField',
					name: 'hides_children',
					label: this.$root.trans.get('validation.attributes.hides_children'),
					options: {required: true}
				},
				{
					type: 'SelectField',
					name: 'children_display_mode',
					label: this.$root.trans.get('validation.attributes.children_display_mode'),
					options: {
						required: true,
						choices: [
							{ value: 30, label: this.$root.trans.get('hierarchy::contents.mode_list')},
							{ value: 40, label: this.$root.trans.get('hierarchy::contents.mode_tree')}
						]
					}
				}
			]
		]
	}},
	methods: {
		saveAndPublish() {
			this.form.status = 50
			this.requestUpdate('contents', '/settings')
		}
	}
}
</script>