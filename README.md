Mutable Laravel links, urls and redirects
====

What?
----

Normal Laravel links, urls and redirects aren't mutable, because they're ready strings. You make
them and that's it. You can't add query params after, and you can't add a `#fragment` at all.

This makes for unreadable links/urls:

	$link = link_to_route('users.show', 'Some label here', ['user' => 321, 'report' => 123], ['title' => 'The title of the link', 'id' => "link-{$user->id}"]);

Which part is a URL component, and which part a custom query param, and which part an HTML attribute..?

How?
----

Add the service provider (happens automatically):

	rdx\linkurl\LinkUrlServiceProvider::class

Make sure `laravelcollective/html` is installed. It makes links.

Links, urls and redirects are mutable objects now:

	// Link: <a href="/users/123?report=14#table-reports">View users</a>
	echo linkurl_to_route('users.show', 'View user', [$user])->query('report', 14)->fragment('table-reports');

	// Link: <a href="/reports/123/delete?_token=huy6543gy654" class="delete">x</a>
	echo linkurl_to_route('reports.delete', 'x', [$report])->add('class', 'delete')->withCsrf();

	// Url: https://example.com/users/123/edit?return=https%3A%2F%2Fexample.com%2Fusers
	$url = routeurl('users.edit', [$user])->query('return', route('users.index'));

	// Redirect: /users/123#table-reports
	return redirect()->route('users.show', [$user])->fragment('table-reports');

Links and Urls are built in `__toString()` at the last moment.
