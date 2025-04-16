module.exports = {
	content: [
		'./*.php',
		'./**/*.php',
		'./template-parts/**/*.php',
		'./woocommerce/**/*.php',
		'./sass/**/*.scss',
		'./js/**/*.js',
	],
	safelist: [
		'flex', 'flex-wrap', 'gap-6', 'w-full', 'sm:w-1/2', 'md:w-1/3', 'lg:w-1/4', 'md:flex-row', 'translate-x-full', 'translate-x-0',
		'products',
	],
	theme: {
		extend: {},
	},
	plugins: [],
};
