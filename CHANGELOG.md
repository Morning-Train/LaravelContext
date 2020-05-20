# Release Notes

## [2.5.0 (2020-05-20)](https://github.com/Morning-Train/LaravelContext/compare/2.4.1...2.5.0)

- An instance of the ContextService are provided to the constructor of loaded contexts.
- Add ContextProvider class that all Contexts should extend going forwards.
- LoadContexts middleware added to be used with ContextProviders

## [2.4.1 (2020-05-03)](https://github.com/Morning-Train/LaravelContext/compare/2.4.0...2.4.1)

- Added contexts booting and booted events

## [2.4.0 (2020-05-03)](https://github.com/Morning-Train/LaravelContext/compare/2.3.0...2.4.0)

- Added contexts booting and booted events

## [2.3.0 (2020-05-02)](https://github.com/Morning-Train/LaravelContext/compare/2.2.1...2.3.0)

- Added historical changelog to GIT repo
- In context service provider, renamed registerFeatures to registerContexts
- Added ContextLoading and ContextLoaded events
- Moved context registering to register method in service provider

## [2.2.1 (2019-03-11)](https://github.com/Morning-Train/LaravelContext/compare/2.2.0...2.2.1)

- Fixed wrong namespace used for EnvPlugin in TranslationPlugin

## [2.2.0 (2019-03-04)](https://github.com/Morning-Train/LaravelContext/compare/2.1.2...2.2.0)

- Added support for Laravel 7.x

## [2.1.2 (2019-12-09)](https://github.com/Morning-Train/LaravelContext/compare/2.1.1...2.1.2)

- In context service, store array of loaded plugins and features
- Added is method to ContextService to easier check which Context is currently loaded

## [2.1.1 (2019-11-08)](https://github.com/Morning-Train/LaravelContext/compare/2.1.0...2.1.1)

- Initial readme content with info about installation and usage
- EnvPlugin updated to be easier to use -> It gets a toString implementation 

## [2.1.0 (2019-11-07)](https://github.com/Morning-Train/LaravelContext/compare/2.0.0...2.1.0)

- Removed unused store plugin

## [2.0.0 (2019-11-07)](https://github.com/Morning-Train/LaravelContext/compare/1.3.0...2.0.0)

- Replace LocalizationPlugin with EnvPlugin and updated references in other plugins

## [1.3.0 (2019-11-07)](https://github.com/Morning-Train/LaravelContext/compare/1.2.2...1.3.0)

- Context localization plugin updated to also provide an env helper 

## [1.2.2 (2019-11-07)](https://github.com/Morning-Train/LaravelContext/compare/1.2.1...1.2.2)

- Updated menu plugin with a page method

## [1.2.1 (2019-11-07)](https://github.com/Morning-Train/LaravelContext/compare/1.2.0...1.2.1)

- Added an all method to Asset registrar to dynamically access entries

## [1.2.0 (2019-11-03)](https://github.com/Morning-Train/LaravelContext/compare/1.1.7...1.2.0)

- Added better error handling in localize registrar - There was an issue when exception is thrown inside

## [1.1.7 (2019-09-04)](https://github.com/Morning-Train/LaravelContext/compare/1.1.6...1.1.7)

- Added Laravel 6.x support
- Minor cleanup

## [1.1.6 (2019-08-27)](https://github.com/Morning-Train/LaravelContext/compare/1.1.5...1.1.6)

- Fixed namespace for Breadcrumbs registrar

## [1.1.5 (2019-08-26)](https://github.com/Morning-Train/LaravelContext/compare/1.1.4...1.1.5)

- Assorted updates from old fork

## [1.1.4 (2019-06-04)](https://github.com/Morning-Train/LaravelContext/compare/1.1.3...1.1.4)

- RoutePlugin updated to also export all query parameters from the request

## [1.1.3 (2019-05-15)](https://github.com/Morning-Train/LaravelContext/compare/1.1.2...1.1.3)

- RoutePlugin updated to also supply parameters of current route

## [1.1.2 (2019-03-21)](https://github.com/Morning-Train/LaravelContext/compare/1.1.1...1.1.2)

- Changed order of context registration
- Renamed readme file to be capitalized

## [1.1.1 (2019-03-19)](https://github.com/Morning-Train/LaravelContext/compare/1.1...1.1.1)

- Changed namespace from MorningTrain\LaravelContext to MorningTrain\Laravel\Context

## [1.1 (2019-03-19)](https://github.com/Morning-Train/LaravelContext/compare/1.0...1.1)

- Minor license update

## [1.0 (2019-03-19)](https://github.com/Morning-Train/LaravelContext)

- Initial release





