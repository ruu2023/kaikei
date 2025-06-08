// import './bootstrap';

// import Alpine from 'alpinejs';

// // Import page-specific modules
// import './dashboard';
// import './analytics';
// import './transaction';
// import './settings';

// window.Alpine = Alpine;

// Alpine.start();

// // Global utilities and navigation
// document.addEventListener('DOMContentLoaded', function() {
//     // Initialize navigation active states
//     initializeNavigation();

//     // Setup common event listeners
//     setupCommonEventListeners();
// });

// /**
//  * Initialize navigation active states
//  */
// function initializeNavigation() {
//     const currentPath = window.location.pathname;
//     const navItems = document.querySelectorAll('.nav-item');

//     navItems.forEach(item => {
//         const href = item.getAttribute('href');
//         if (href && currentPath.includes(href.replace('{{ route(\'', '').replace('\') }}', ''))) {
//             item.classList.add('active');
//         } else {
//             item.classList.remove('active');
//         }
//     });
// }

// /**
//  * Setup common event listeners
//  */
// function setupCommonEventListeners() {
//     // Handle responsive navigation
//     handleResponsiveNavigation();

//     // Setup global modal handlers
//     setupGlobalModalHandlers();
// }

// /**
//  * Handle responsive navigation
//  */
// function handleResponsiveNavigation() {
//     // This can be expanded for mobile menu functionality
//     const bottomNav = document.querySelector('.bottom-nav');
//     if (bottomNav) {
//         // Add any responsive behavior here
//     }
// }

// /**
//  * Setup global modal handlers
//  */
// function setupGlobalModalHandlers() {
//     // Global modal close on Escape key
//     document.addEventListener('keydown', function(e) {
//         if (e.key === 'Escape') {
//             const openModals = document.querySelectorAll('.modal.show');
//             openModals.forEach(modal => {
//                 modal.classList.remove('show');
//             });
//         }
//     });
// }

// /**
//  * Global utility functions
//  */
// window.appUtils = {
//     formatCurrency: function(amount) {
//         return new Intl.NumberFormat("ja-JP", {
//             style: "currency",
//             currency: "JPY",
//             maximumFractionDigits: 0,
//         }).format(amount);
//     },

//     formatDate: function(date) {
//         return new Date(date).toLocaleDateString('ja-JP', {
//             year: 'numeric',
//             month: 'long',
//             day: 'numeric'
//         });
//     },

//     showNotification: function(message, type = 'info') {
//         // Simple notification system
//         console.log(`${type.toUpperCase()}: ${message}`);
//         // This can be expanded to show actual notifications
//     }
// };
