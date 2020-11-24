<template>
	<div class="activity-feed">
		<div v-for="(activity, index) in activities" v-if="activities.length > 0">
			<div class="activity" v-if="activity.causer != null">
				<div class="activity__causer-outer">
					<div class="activity__causer">
						<img :src="activity.causer.gravatar" alt="Avatar" class="activity__avatar"><span class="activity__initials" v-text="activity.causer.initials"></span>
					</div>
					<div class="activity__subject" v-if="activity.subject && (activity.subject_type.endsWith('User') || activity.subject_type.endsWith('Medium'))">
						<div v-if="activity.subject_type.endsWith('User')">
							<img :src="activity.subject.gravatar" alt="Avatar" class="activity__avatar"><span class="activity__initials" v-text="activity.subject.initials"></span>
						</div>
						<div v-if="activity.subject_type.endsWith('Medium')">
							<img class="activity__avatar" v-if="activity.subject.thumbnail_url" :src="activity.subject.thumbnail_url">
							<div class="medium-thumbnail-icon has-color-white" v-if="activity.subject.type != 'image'">
								<span class="icon is-large">
									<i :class="thumbnailIcon(activity.subject.type)"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="activity__content">
					<p class="activity__date" v-text="readableDate(activity.created_at)"></p>
					<p class="activity__text"><router-link :to="{ name: 'users.edit', params: {id: activity.causer_id} }" v-text="activity.causer.first_name"></router-link> <component
							:key="index"
							:is="activity.description"
							:activity="activity">
						</component>
					</p>
				</div>
			</div>
		</div>
		<button class="mt-md is-uppercase button is-fullwidth" @click.prevent="load()" v-if="canLoadMore && activities.length > 0" v-text="trans.get('foundation::general.load_more')"></button>
		<p v-if="activities.length == 0 && isLoaded" class="pt-xxl pb-xxl is-size-5 has-text-centered" v-text="trans.get('auth::users.no_activity')"></p>
	</div>
</template>

<script>
import {ImageUpdated, MediaDestroyedBulk, MediumDestroyed, MediumEmbedded, MediumUpdated, MediumUploaded} from 'umomega-media'
import {PermissionDestroyed, PermissionRevoked, PermissionsDestroyedBulk, PermissionStored, PermissionUpdated, ProfileUpdated, ProfileUpdatedPassword, RoleDestroyed, RoleRevoked, RolesDestroyedBulk, RoleStored, RoleUpdated, UserDestroyed, UsersDestroyedBulk, UserStored, UserUpdated, UserUpdatedPassword} from 'umomega-auth'
import {TagDestroyed, TagsDestroyedBulk, TagStored, TagTranslated, TagTranslationDestroyed, TagUpdated} from 'umomega-tags'
import {format_date_for_humans, assess_error} from 'umomega-foundation'
import {ContentTypeDestroyed, ContentTypesDestroyedBulk, ContentTypeStored, ContentTypeUpdated, ContentTypeDuplicated, ContentFieldDestroyed, ContentFieldStored, ContentFieldUpdated, ContentDestroyed, ContentDuplicated, ContentMoved, ContentTransformed, ContentUpdated, ContentStored, ContentTranslated, ContentSettingsUpdated, ContentStateUpdated, ContentTranslationDestroyed, ContentsDestroyedBulk} from 'nuclear-hierarchy-ui'


export default {
	components: { ImageUpdated, MediaDestroyedBulk, MediumDestroyed, MediumEmbedded, MediumUpdated, MediumUploaded, PermissionDestroyed, PermissionRevoked, PermissionsDestroyedBulk, PermissionStored, PermissionUpdated, ProfileUpdated, ProfileUpdatedPassword, RoleDestroyed, RoleRevoked, RolesDestroyedBulk, RoleStored, RoleUpdated, UserDestroyed, UsersDestroyedBulk, UserStored, UserUpdated, UserUpdatedPassword, TagDestroyed, TagsDestroyedBulk, TagStored, TagTranslated, TagTranslationDestroyed, TagUpdated, ContentTypeDestroyed, ContentTypesDestroyedBulk, ContentTypeDuplicated, ContentTypeStored, ContentTypeUpdated, ContentFieldDestroyed, ContentFieldStored, ContentFieldUpdated, ContentDestroyed, ContentDuplicated, ContentMoved, ContentTransformed, ContentUpdated, ContentStored, ContentTranslated, ContentSettingsUpdated, ContentStateUpdated, ContentTranslationDestroyed, ContentsDestroyedBulk },
	props: ['loadurl'],
	data() { return {
		activities: [],
		skip: 0,
		canLoadMore : true,
		isBusy: false,
		isLoaded: false
	}},
	created() {
		this.load()
	},
	methods: {
		load() {
			if(!this.canLoadMore || this.isBusy) return false;

			var self = this;
			this.isBusy = true;

			axios.get(api_url_with_token(this.loadurl) + '&s=' + this.skip)
				.then(function(response) {
					if(response.data.length < 30) self.canLoadMore = false

					self.activities = [...self.activities, ...response.data]
					self.isBusy = false
					self.skip = self.skip + 30

					if(!self.isLoaded) self.isLoaded = true
				})
				.catch(function(error) { assess_error(error) })
		},
		readableDate(date) {
			return format_date_for_humans(date);
		},
		thumbnailIcon(type) {
			return 'fas fa-' + (type == 'document' ? 'file' : 'file' + type)
		}
	}
}
</script>