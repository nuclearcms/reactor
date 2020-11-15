// Dashboard
import DashboardOverview from './views/dashboard/DashboardOverview'
import DashboardChronicle from './views/dashboard/DashboardChronicle'

// Media
import {MediaIndex, MediaUpload, MediaEmbed, MediaEdit, MediaImage} from 'umomega-media'

// Tags
import {TagsIndex, TagsCreate, TagsTranslate} from 'umomega-tags'
import TagsEdit from './views/tags/TagsEdit'

// Permissions
import {PermissionsIndex, PermissionsCreate, PermissionsEdit, PermissionsUsers} from 'umomega-auth'
// Roles
import {RolesIndex, RolesCreate, RolesEdit, RolesUsers} from 'umomega-auth'
// Users
import {UsersIndex, UsersCreate, UsersEdit, UsersPassword} from 'umomega-auth'
import UsersChronicle from './views/users/UsersChronicle'
// Profile
import {ProfileEdit, ProfilePassword} from 'umomega-auth'
import ProfileChronicle from './views/profile/ProfileChronicle'

// Hierarchy
import {ContentTypesIndex, ContentTypesCreate, ContentTypesEdit, ContentTypesFields, ContentFieldsCreate, ContentFieldsEdit} from 'nuclear-hierarchy-ui'

// Errors
import {NotFound, Unauthorized, Internal} from 'umomega-foundation'

export default {
    mode: 'history',
    base: '/reactor',

    routes: [
        // Errors
        {path: '*', component: NotFound},
        {path: '/notfound', component: NotFound, name: 'errors.notfound'},
        {path: '/unauthorized', component: Unauthorized, name: 'errors.unauthorized'},
        {path: '/internal', component: Internal, name: 'errors.internal'},

        // Dashboard
        {path: '/', component: DashboardOverview, name: 'dashboard.overview'},
        {path: '/activity', component: DashboardChronicle, name: 'dashboard.chronicle'},
        
        // Media
        {path: '/media', component: MediaIndex, name: 'media.index'},
        {path: '/media/upload', component: MediaUpload, name: 'media.upload'},
        {path: '/media/embed', component: MediaEmbed, name: 'media.embed'},
        {path: '/media/:id/edit/:locale?', component: MediaEdit, name: 'media.edit'},
        {path: '/media/:id/image', component: MediaImage, name: 'media.image'},

        // Tags
        {path: '/tags', component: TagsIndex, name: 'tags.index'},
        {path: '/tags/create', component: TagsCreate, name: 'tags.create'},
        {path: '/tags/:id/edit/:locale?', component: TagsEdit, name: 'tags.edit'},
        {path: '/tags/:id/translate', component: TagsTranslate, name: 'tags.translate'},

        // Users
        {path: '/users', component: UsersIndex, name: 'users.index'},
        {path: '/users/create', component: UsersCreate, name: 'users.create'},
        {path: '/users/:id/edit', component: UsersEdit, name: 'users.edit'},
        {path: '/users/:id/password', component: UsersPassword, name: 'users.password'},
        {path: '/users/:id/chronicle', component: UsersChronicle, name: 'users.chronicle'},

        // Permissions
        {path: '/permissions', component: PermissionsIndex, name: 'permissions.index'},
        {path: '/permissions/create', component: PermissionsCreate, name: 'permissions.create'},
        {path: '/permissions/:id/edit', component: PermissionsEdit, name: 'permissions.edit'},
        {path: '/permissions/:id/users', component: PermissionsUsers, name: 'permissions.users'},

        // Roles
        {path: '/roles', component: RolesIndex, name: 'roles.index'},
        {path: '/roles/create', component: RolesCreate, name: 'roles.create'},
        {path: '/roles/:id/edit', component: RolesEdit, name: 'roles.edit'},
        {path: '/roles/:id/users', component: RolesUsers, name: 'roles.users'},

        // Content Types
        {path: '/contenttypes', component: ContentTypesIndex, name: 'contenttypes.index'},
        {path: '/contenttypes/create', component: ContentTypesCreate, name: 'contenttypes.create'},
        {path: '/contenttypes/:id/edit', component: ContentTypesEdit, name: 'contenttypes.edit'},
        {path: '/contenttypes/:id/fields', component: ContentTypesFields, name: 'contenttypes.fields'},

        // Content Fields
        {path: '/contenttypes/:id/fields/create', component: ContentFieldsCreate, name: 'contentfields.create'},
        {path: '/contenttypes/:parent/fields/:id', component: ContentFieldsEdit, name: 'contentfields.edit'},

        // Profile
        {path: '/profile', component: ProfileEdit, name: 'profile.edit'},
        {path: '/profile/password', component: ProfilePassword, name: 'profile.password'},
        {path: '/profile/chronicle', component: ProfileChronicle, name: 'profile.chronicle'},
    ]
};