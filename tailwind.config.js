module.exports = {
	purge: [
		"./resources/**/*.blade.php",
		"./resources/**/*.js",
		"./node_modules/flowbite/**/*.js"
	],
	darkMode: false,
	theme: {
		extend: {
			fontFamily: {
				'nunito': ['nunito', 'sans-serif']
			},
			colors: {
				'primary': '#3C5AC2',
				'secondary': '#647ACB',
			}
		}
	},
	variants: {
		extend: {},
	},
	plugins: [
		require('flowbite/plugin')
	],
}