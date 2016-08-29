经测试，百川下，很多文件都是只读的
1# WARNING: The TCP backlog setting of 511 cannot be enforced because /proc/sys/net/core/somaxconn is set to the lower value of 128.
echo 511 > /proc/sys/net/core/somaxconn

2# Server started, Redis version 3.0.5

3# WARNING overcommit_memory is set to 0! Background save may fail under low memory condition. To fix this issue add 'vm.overcommit_memory = 1' to /etc/sysctl.conf and then reboot or run the command 'sysctl vm.overcommit_memory=1' for this to take effect.
1.  echo "vm.overcommit_memory=1" > /etc/sysctl.conf  或 vi /etc/sysctl.conf , 然后reboot重启机器
2.  echo 1 > /proc/sys/vm/overcommit_memory  不需要启机器就生效

4# WARNING you have Transparent Huge Pages (THP) support enabled in your kernel. This will create latency and memory usage issues with Redis. To fix this issue run the command 'echo never > /sys/kernel/mm/transparent_hugepage/enabled' as root, and add it to your /etc/rc.local in order to retain the setting after a reboot. Redis must be restarted after THP is disabled.

