Assuming terminal vim on a flavor of *nix:

To suspend your running vim

Ctrl+Z

will suspend the process and get back to your shell

fg
will resume (bring to foreground) your suspended vim

To start a new shell

start a subshell using:

:sh
(as configured by)

:set shell?
or

:!bash
followed by:

Ctrl+D (or exit, but why type so much?)

to kill the shell and return to vim