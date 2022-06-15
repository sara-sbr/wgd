README

Thank you for inviting me to do your developer test.

The frontend test took about 2h to make my page look like the PDF, but I spent a little extra adding some hover effects. I may have gone overboard on the exact transforms for each image - I know you said don't worry about making it pixel perfect but at the same time, you are testing our attention to detail! However I'm sure in a real build all the images would have the same transform applied (and probably be the same size in the source by using a WP custom image size).
I built it in Chrome/Mac but it should work on any desktop browser
If I had longer I would have made a responsive mobile version (make the 3 cards into a slider for example, or simply stack into 1 column).

The backend test took me probably more like 3h but I didn't want to leave any of it incomplete. 
The import can be run via an admin page which appears as an admin menu link.
It can be re-run and handle new locations / categories being added to the file, while not duplicating those that already exist - therefore I wrote it to import from https://gitlab.com/wholegrain/webdeveloper-test/-/raw/master/backend-test/locations.csv rather than the static file in the repository.
If this were a real project we would have to consider whether to archive/delete any locations that disappear from the import csv.

I've tried to put other comments in my code as I went along - however feel free to contact me with any questions on sara@louisefox.co.uk