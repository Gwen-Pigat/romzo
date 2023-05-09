/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */


// assets/app.js
import { registerSvelteControllerComponents } from '@symfony/ux-svelte';

// Registers Svelte controller components to allow loading them from Twig
//
// Svelte controller components are components that are meant to be rendered
// from Twig. These component can then rely on other components that won't be
// called directly from Twig.
//
// By putting only controller components in `svelte/controllers`, you ensure that
// internal components won't be automatically included in your JS built file if
// they are not necessary.
registerSvelteControllerComponents(require.context('./svelte/controllers', true, /\.svelte$/));

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
import './core';
