Contributing
=================================================

These are some guidelines to follow when submitting code to this repository:


Basic Guidelines
-------------------------------------------------

- work in a separate branch, follow the branch naming rules (see below)
- work in small, granular commits and follow the commit message guidelines (see below)
- provide a pull request with *usefull* title *and* description
- all your work for this repo is under the same license as the rest of the repo (see LICENSE.md)


Branch Naming
-------------------------------------------------

Categorize your branch as `bugfix`, `feature`, or `release` and name it accordingly:

- bugfix-xxx
- feature-xxx
- release-xxx

where xxx is to be replaced with a reasonable reference to what you did.

E.g.: `bugfix-oauth-token-mismatch` or `feature-auto-refresh-oauth-token`


Commit Messages
-------------------------------------------------

Make sure your commits have a "title" *and* a description.

The title should be a continuation of "this commit will...", like *this commit will* `Provide a caching implementation of the http client`, where `Provide a caching implementation of the http client` is the commit message.

I really love commit messages that are written [like this](http://chris.beams.io/posts/git-commit/).
