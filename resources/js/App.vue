<template>
	<div class="app">
		
		<div class="notifications">
			<notifications :width="'20rem'" :duration="5000">
				<template slot="body" slot-scope="props">
					<Notification :notification="props"/>
				</template>
			</notifications>
		</div>

		<div class="app__bar">

			<div class="app__sidebar app__control">
				<button class="is-pulled-left is-hidden-desktop navigation-button mr-xl" @click.prevent="openContentsNavigation()">
					<i class="icon fas fa-stream"></i>
				</button>

				<router-link :to="{ name: 'dashboard.overview' }" class="is-inline-block" exact>
					<img src="/vendor/app/img/app-logo-mono.svg" alt="Nuclear Logo" class="app__logo">
				</router-link>

				<button class="is-pulled-right is-hidden-tablet navigation-button ml-xl" @click.prevent="openToolsNavigation()">
					<i class="icon fas fa-ellipsis-v"></i>
				</button>
			</div>

			<div :class="toolsOpen ? 'app__main app__tools app__tools--open' : 'app__main app__tools'">
				<ToolsNavigation/>
			</div>

		</div>

		<div class="app__body">

			<aside class="app__sidebar">
				<div :class="contentsOpen ? 'app__sidebar-inner app__sidebar-inner--open': 'app__sidebar-inner'">
					<ContentsNavigation/>		
				</div>
			</aside>

			<main class="app__main">			

				<Header/>

				<router-view></router-view>
			</main>

			<div :class="contentsOpen || toolsOpen ? 'overlay overlay--open' : 'overlay'" @click.prevent="closeNavigations()"></div>
		</div>

		<div class="app__bar">
			<div class="app__sidebar app__footer">
				<footer class="footer">
					<a href="https://github.com/NuclearCMS/Nuclear" target="_blank" class="footer__link">{{ $root.shared.nuclear_version }}<img src="/vendor/app/img/app-logo-mono.svg" alt="Nuclear Logo" class="footer__icon"></a>
					<span class="footer__separator"></span>
					<a href="https:/umomega.com" target="_blank" class="footer__link"><img src="/vendor/app/img/umo-logo-mono.svg" alt="umΩ Logo" class="footer__icon"></a>
				</footer>
			</div>

		</div>

		<DeleteModal/>

	</div>
</template>

<script>
import {Notification, DeleteModal} from 'umomega-foundation';
// https://codeburst.io/global-loader-component-using-vue-js-and-axios-interceptors-3880a136a4ac
import Header from './partials/Header';
import ContentsNavigation from './partials/ContentsNavigation';
import ToolsNavigation from './partials/ToolsNavigation';

export default {
	components: { ContentsNavigation, ToolsNavigation, Header, Notification, DeleteModal },
	data() { return {
		contentsOpen: false,
		toolsOpen: false
	}},
	watch: {
		$route() {
			this.closeNavigations()
		}
	},
	methods: {
		openContentsNavigation() {
			this.contentsOpen = true
			document.querySelector('html,body').classList.add('is-clipped')
		},
		openToolsNavigation() {
			this.toolsOpen = true
			document.querySelector('html,body').classList.add('is-clipped')
		},
		closeNavigations() {
			this.contentsOpen = false
			this.toolsOpen = false
			document.querySelector('html,body').classList.remove('is-clipped')
		}
	}
}
</script>