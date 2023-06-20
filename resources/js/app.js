import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
window.Alpine = Alpine;

import 'flowbite';


import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
import './../../vendor/power-components/livewire-powergrid/dist/powergrid.css'
import './../../node_modules/flatpickr/dist/flatpickr.min.css'
import flatpickr from "flatpickr";
window.flatpickr = flatpickr;

Alpine.plugin(focus);

Alpine.start();

