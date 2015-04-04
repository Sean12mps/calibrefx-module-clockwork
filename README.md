# calibrefx-module-clockwork

[installation]
- add this to calibrefx module folder
- activate it in calibrefx module settings
- make a folder in childtheme named clockwork
- inside folder clockwork, make a file named cfx-functions.php

[how-to]
- open any page or post setting in wp-admin
- open and activate the clockwork interface metabox
- update the post
- click the "+" button to add custom hook

[rule]
- slug-field ( cannot be the same on the same post id )

- loop-action( to add or to remove an action )

- hook-name( currently registered hooks ). If typed "calibrefx_" will show a number of calibrefx layout hooks

- function-name( the function you would like to add. 
  Note that you have to make that function in cfx-functions.php ).
  if remove action is chosen, the command will switch to removing a function 
  that's registered instead( autocomplete is available ).
  
- hook-priority( the priority in which the action is called/removed ). 
  If the action is remove, when registered function name is chosen
  this will be set automatically to the priority it was originally 
  called ( so we don't have to quick-find our themes for function name again anymore.

[extra]
- hookform is draggable, sortable, can be deleted, and also added.

[to-dos]
- need more styling
- need more logic
- need for code-qc
- need more discussions
