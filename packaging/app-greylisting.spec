
Name: app-greylisting
Epoch: 1
Version: 2.0.0
Release: 1%{dist}
Summary: Greylisting
License: GPLv3
Group: ClearOS/Apps
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base
Requires: app-smtp

%description
The Greylisting app provides additional protection against spam and viruses by filtering out non-compliant e-mail messages.

%package core
Summary: Greylisting - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: app-smtp-core
Requires: postgrey >= 1.33-2

%description core
The Greylisting app provides additional protection against spam and viruses by filtering out non-compliant e-mail messages.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/greylisting
cp -r * %{buildroot}/usr/clearos/apps/greylisting/

install -D -m 0644 packaging/postgrey.php %{buildroot}/var/clearos/base/daemon/postgrey.php

%post
logger -p local6.notice -t installer 'app-greylisting - installing'

%post core
logger -p local6.notice -t installer 'app-greylisting-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/greylisting/deploy/install ] && /usr/clearos/apps/greylisting/deploy/install
fi

[ -x /usr/clearos/apps/greylisting/deploy/upgrade ] && /usr/clearos/apps/greylisting/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-greylisting - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-greylisting-core - uninstalling'
    [ -x /usr/clearos/apps/greylisting/deploy/uninstall ] && /usr/clearos/apps/greylisting/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/greylisting/controllers
/usr/clearos/apps/greylisting/htdocs
/usr/clearos/apps/greylisting/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/greylisting/packaging
%dir /usr/clearos/apps/greylisting
/usr/clearos/apps/greylisting/deploy
/usr/clearos/apps/greylisting/language
/usr/clearos/apps/greylisting/libraries
/var/clearos/base/daemon/postgrey.php
