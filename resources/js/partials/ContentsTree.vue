<template>
	<draggable :list="contents" :group="{name: 'nested'}" handle=".content-item__icon" :sort="canSort" :tag="'ul'" :animation="200" :class="'contents-tree' + (can ? '' : ' contents-tree--readonly') + (isSorting ? ' contents-tree--disabled' : '')" :filter="'.is-locked'" @end="updateOrder" :data-id="parentId">
		<li v-for="content in contents" v-if="content.title[editingLocale] != undefined" :class="'content-item' + (content.hides_children || content.content_type.hides_children ? ' content-item--has-children' : '') + (locked || content.is_locked ? ' is-locked' : '')" :key="content.id" :data-id="content.id">
			<div class="is-relative content-item__title">
				<span v-if="content.id == $root.store.home_content" class="content-item__icon content-item__icon content-item__icon--home"><i class="is-size-8 fas fa-home has-color-grey"></i></span>
				<span v-else class="content-item__icon">
					<span v-if="showsthumbnails" class="content-item__thumb">
						<img :src="content.cover_thumbnail">
					</span>
				</span>
				<router-link :to="{ name: (content.hides_children || content.content_type.hides_children ? 'contents.children' : 'contents.edit'), params: {id: content.id, locale: editingLocale} }" v-text="content.title[editingLocale]" class="content-item__link"/><i v-if="content.is_locked" class="is-size-9 fas fa-lock has-color-grey-light"></i> <i v-if="content.is_sterile" class="is-size-9 far fa-dot-circle has-color-grey-light"></i>
				<div class="content-item__options">
					<ContentsDropdown :can="can" :content="content">
						<template v-slot:trigger>
							<button aria-haspopup="true" class="content-item__options-button"><i class="icon fas fa-ellipsis-v"></i></button>
						</template>
					</ContentsDropdown>
				</div>
			</div>
			<ContentsTree v-if="!content.is_sterile && (!content.hides_children && !content.content_type.hides_children) && content.content_type.allowed_children_types.length > 0" :contents="content.tree" :can="canSort" :editingLocale="editingLocale" :locked="content.is_locked" :parentId="content.id" :showsthumbnails="showsthumbnails"/>
		</li>
	</draggable>
</template>

<script>
import {assess_error} from 'umomega-foundation'
import ContentsDropdown from './ContentsDropdown'
import draggable from 'vuedraggable'

export default {
	name: 'ContentsTree',
	props: ['contents', 'editingLocale', 'can', 'locked', 'parentId', 'showsthumbnails'],
	components: {ContentsDropdown, draggable},
	data() { return {
		isSorting: false
	}},
	methods: {
		updateOrder(value) {
			const self = this

			var route = 'contents/' + value.item.dataset.id + '/move'
			if(value.to.dataset.id) route += '/' + value.to.dataset.id

			self.isSorting = true

			axios.put(api_url_with_token(route), {position: value.newIndex})
				.then(function(response) {
					self.isSorting = false
					self.notifier.success(response.data.message)
					Event.$emit(response.data.event, {})
				})
				.catch(function(error) {
					self.isSorting = false
					Event.$emit('content-tree-modified')
					self.notifier.danger(error.response.data.message)
					assess_error(error)
				})
		}
	},
	computed: {
		canSort() {
			return !this.isSorting && this.can
		}
	}
}
</script>