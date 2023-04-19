/* eslint-disable @typescript-eslint/no-var-requires */
module.exports = {
	branches: [
		'release',
		{
			name: 'alpha',
			prerelease: 'alpha',
		},
	],
	prepare: [
		'@semantic-release/changelog',
		'@semantic-release/npm',
		[
			'semantic-release-version-bump',
			{
				// build script is run before semantic-release, so the version in *.css files
				// have to be updated explicitly
				files: [ 'src/scss/_theme-description.scss', 'style.css' ],
				callback: 'npm run release:archive',
			},
		],
		{
			path: '@semantic-release/git',
			assets: [
				'src/scss/_theme-description.scss',
				'package.json',
				'package-lock.json',
				'CHANGELOG.md',
			],
			message: 'chore(release): ${nextRelease.version} [skip ci]\n\n${nextRelease.notes}',
		},
	],
	plugins: [
		'@semantic-release/commit-analyzer',
		'@semantic-release/release-notes-generator',
		[
			'@semantic-release/npm',
			{
				npmPublish: false,
			},
		],
		'semantic-release-version-bump',
		[
			'@semantic-release/github',
			{
				assets: [
					{
						path: './release/newspack-block-theme.zip',
						label: 'newspack-block-theme.zip',
					}
				]
			},
		],
	],
};
