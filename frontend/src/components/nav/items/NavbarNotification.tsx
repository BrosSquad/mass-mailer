import { Badge, IconButton } from "@material-ui/core";
import { Notifications as NotificationsIcon } from "@material-ui/icons";
import React from 'react';
import NavbarMenuItem from "./NavbarMenuItem";
import { NavbarMenuProps } from "./props";

const NavbarNotification = ( { color, numberOfNotifications, isMobile }: NavbarMenuProps ) => {
	return (
		<NavbarMenuItem isMobile={ isMobile } name={ 'Notifications' }>
			<IconButton color="inherit">
				<Badge badgeContent={ numberOfNotifications } color={ color ?? 'secondary' }>
					<NotificationsIcon/>
				</Badge>
			</IconButton>
		</NavbarMenuItem>
	)
};

export default NavbarNotification;
