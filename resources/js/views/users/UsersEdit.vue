<template>
    <div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
        <div class="has-text-centered mb-lg">
            <p class="is-size-4">{{ resource.full_name }}</p>
        </div>

        <tabs class="is-marginless" :tabs="[
            { route: 'users.edit', label: 'auth::users.single', active: true },
            { route: 'users.password', label: 'validation.attributes.password', active: false, show: 'write_users' },
            { route: 'users.chronicle', label: 'auth::users.activity', active: false, show: 'read_chronicle' }
        ]"></tabs>

        <div class="paper">
            <form method="POST" action="/api/users" @submit.prevent="requestUpdate('users')" autocomplete="off">

                <div class="paper__body paper__body--noside">
                    <div class="paper__main">
                        <FormBody :schema="schema" v-model="form" :readonly="!$can('write_users')" />
                    </div>
                </div>

                <SubmitFooter v-if="$can('write_users')" :config="{ icon: 'save' }" v-model="form"></SubmitFooter>

            </form>
        </div>
    </div>
</template>

<script>
import { View, Updater, Shower, Tabs, FormBody, Form, SubmitFooter, RequiresPermissions } from 'umomega-foundation'

export default {
    mixins: [View, RequiresPermissions, Updater, Shower],
    components: { FormBody, SubmitFooter, Tabs },
    data() {
        return {
            titleLabel: 'auth::users.edit',
            breadcrumbs: [
                { to: { name: 'users.index' }, text: this.$root.trans.get('auth::users.multiple') }
            ],
            guardedBy: 'read_users',
            showRoute: 'users',
            form: new Form({ first_name: '', last_name: '', email: '', roles_list: [], permissions_list: [], locale: this.$root.appLocale, contents_list: [] }),
            schema: [
                {
                    type: 'EmailField',
                    name: 'email',
                    label: this.$root.trans.get('validation.attributes.email'),
                    options: { required: true },
                    hint: this.$root.trans.get('auth::auth.hint_email')
                },
                {
                    type: 'TextField',
                    name: 'first_name',
                    label: this.$root.trans.get('validation.attributes.first_name'),
                    options: { required: true }
                },
                {
                    type: 'TextField',
                    name: 'last_name',
                    label: this.$root.trans.get('validation.attributes.last_name'),
                    options: { required: true }
                },
                {
                    type: 'RelationField',
                    name: 'roles_list',
                    label: this.$root.trans.get('auth::roles.multiple'),
                    placeholder: this.$root.trans.get('auth::roles.search'),
                    options: { multiple: true, searchroute: 'roles/search' }
                },
                {
                    type: 'RelationField',
                    name: 'permissions_list',
                    label: this.$root.trans.get('auth::permissions.multiple'),
                    placeholder: this.$root.trans.get('auth::permissions.search'),
                    options: { multiple: true, searchroute: 'permissions/search' }
                },
                {
                    type: 'SelectField',
                    name: 'locale',
                    label: this.$root.trans.get('validation.attributes.locale'),
                    options: {
                        required: true,
                        choices: [
                            { value: 'en', label: 'English' },
                            { value: 'tr', label: 'Türkçe' },
                        ]
                    }
                },
                {
                    type: 'RelationField',
                    name: 'contents_list',
                    label: this.$root.trans.get('hierarchy::contents.multiple'),
                    placeholder: this.$root.trans.get('hierarchy::contents.search'),
                    options: { multiple: true, searchroute: 'contents/search/relatable', namekey: 'title', translated: true}
                },
            ]
        }
    }
}
</script>