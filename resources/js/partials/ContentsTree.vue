<template>
	<draggable :list="contents" :group="{name: 'nested'}" handle=".content-item__icon" :sort="can" :tag="'ul'" :animation="200" :class="'contents-tree' + (can ? '' : ' contents-tree--readonly')" :filter="'.is-locked'" @end="updateOrder" :data-id="parentId">
		<li v-for="content in contents" v-if="content.title[editingLocale] != undefined" :class="'content-item' + (content.hides_children || content.content_type.hides_children ? ' content-item--has-children' : '') + (locked || content.is_locked ? ' is-locked' : '')" :key="content.id" :data-id="content.id">
			<div class="is-relative">
				<span v-if="content.id == $root.store.home_content" class="content-item__icon content-item__icon content-item__icon--home"><i class="is-size-8 fas fa-home has-color-grey"></i></span>
				<span v-else class="content-item__icon"></span>
				<router-link :to="{ name: (content.hides_children || content.content_type.hides_children ? 'contents.children' : 'contents.edit'), params: {id: content.id} }" v-text="content.title[editingLocale]" class="content-item__link"/><i v-if="content.is_locked" class="is-size-9 fas fa-lock has-color-grey-light"></i> <i v-if="content.is_sterile" class="is-size-9 fas fa-comment-slash has-color-grey-light"></i>
				<div class="content-item__options">
					<ContentsDropdown :can="can" :content="content">
						<template v-slot:trigger>
							<button aria-haspopup="true" class="content-item__options-button"><i class="icon fas fa-ellipsis-v"></i></button>
						</template>
					</ContentsDropdown>
				</div>
			</div>
			<ContentsTree v-if="!content.is_sterile && (!content.hides_children && !content.content_type.hides_children) && content.content_type.allowed_children_types.length > 0" :contents="content.tree" :can="can" :editingLocale="editingLocale" :locked="content.is_locked" :parentId="content.id"/>
		</li>
	</draggable>
</template>

<script>
import ContentsDropdown from './ContentsDropdown'
import draggable from 'vuedraggable'

export default {
	name: 'ContentsTree',
	props: ['contents', 'editingLocale', 'can', 'locked', 'parentId'],
	components: {ContentsDropdown, draggable},
	methods: {
		updateOrder(value) {
			console.log(value.to.dataset.id, value.newIndex, value.item.dataset.id)
			// parent id, position, self id
		}
	}
}
</script>