
This is just a random experiment to demo the little PHP mini-libraries.

## light weight content render

This is the document that will be used to generate [index.html](./markdown.md) from a markdown source file.
In it you might link to other pages, etc.  The way it gets render to as HTML is based on the contents
of a JSON file named resting.json.  This file includes a map of page names and their template.


```javascript
    {
	"template-engine": {
		"bin": "template-engine",
		"options": ["--md-dir=docs", "--html-dir=html", "--publish-md=true"]
	},
        "site-map": [
		["/index.html", "index.md"],
                ["/about.html", "about.md"]
        ]
    }
```

This, of course, is all hypothetical at the moment.



