// Dashboard
import DashboardOverview from './views/dashboard/DashboardOverview'
import DashboardChronicle from './views/dashboard/DashboardChronicle'

// Media
import {MediaIndex, MediaUpload, MediaEmbed, MediaEdit, MediaImage} from 'umomega-media'

// Tags
import {TagsIndex, TagsCreate, TagsTranslate} from 'umomega-tags'
import TagsEdit from './views/tags/TagsEdit'
import TagsContents from './views/tags/TagsContents'

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

import {ContentsIndex, ContentsCreate, ContentsEdit, ContentsTranslate, ContentsSettings, ContentsTransform, ContentTypesContents, ContentsChildren} from 'nuclear-hierarchy-ui'
import ContentsStatistics from './views/contents/ContentsStatistics'

// Former
import {FormsIndex, FormsCreate, FormsEdit, FormsFields, FormFieldsCreate, FormFieldsEdit, AnswersIndex, AnswersEdit} from 'umomega-former'

// Maintenance
import ManageEnvironment from './views/ManageEnvironment'
import ManageLogs from './views/ManageLogs'
import MaintainReactor from './views/MaintainReactor'

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

        // Contents
        {path: '/contents', component: ContentsIndex, name: 'contents.index'},
        {path: '/contents/create/:parent?', component: ContentsCreate, name: 'contents.create'},
        {path: '/contents/:id/edit/:locale?', component: ContentsEdit, name: 'contents.edit'},
        {path: '/contents/:id/translate', component: ContentsTranslate, name: 'contents.translate'},
        {path: '/contents/:id/settings', component: ContentsSettings, name: 'contents.settings'},
        {path: '/contents/:id/transform', component: ContentsTransform, name: 'contents.transform'},
        {path: '/contents/:id/statistics', component: ContentsStatistics, name: 'contents.statistics'},
        {path: '/contents/:id/children/:locale?', component: ContentsChildren, name: 'contents.children'},
        
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
        {path: '/tags/:id/contents', component: TagsContents, name: 'tags.contents'},

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
        {path: '/contenttypes/:id/contents', component: ContentTypesContents, name: 'contenttypes.contents'},

        // Content Fields
        {path: '/contenttypes/:id/fields/create', component: ContentFieldsCreate, name: 'contentfields.create'},
        {path: '/contenttypes/:parent/fields/:id', component: ContentFieldsEdit, name: 'contentfields.edit'},

        // Former Forms
        {path: '/forms', component: FormsIndex, name: 'forms.index'},
        {path: '/forms/create', component: FormsCreate, name: 'forms.create'},
        {path: '/forms/:id/edit', component: FormsEdit, name: 'forms.edit'},
        {path: '/forms/:id/fields', component: FormsFields, name: 'forms.fields'},

        // Former Fields
        {path: '/forms/:id/fields/create', component: FormFieldsCreate, name: 'formfields.create'},
        {path: '/forms/:parent/fields/:id', component: FormFieldsEdit, name: 'formfields.edit'},

        // Former Answers
        {path: '/answers', component: AnswersIndex, name: 'answers.index'},
        {path: '/answers/:id/edit', component: AnswersEdit, name: 'answers.edit'},

        // Maintenance
        {path: '/environment', component: ManageEnvironment, name: 'environment'},
        {path: '/logs', component: ManageLogs, name: 'logs'},
        {path: '/maintenance', component: MaintainReactor, name: 'maintenance'},

        // Profile
        {path: '/profile', component: ProfileEdit, name: 'profile.edit'},
        {path: '/profile/password', component: ProfilePassword, name: 'profile.password'},
        {path: '/profile/chronicle', component: ProfileChronicle, name: 'profile.chronicle'},
    ]
};