import { Badge, IconButton } from "@material-ui/core";
import { Mail as MailIcon } from "@material-ui/icons";
import React from 'react';
import NavbarMenuItem from "./NavbarMenuItem";
import { NavbarMenuProps } from "./props";


const NavbarMessages = ( { isMobile, color, name, numberOfNotifications }: NavbarMenuProps ) => (
	<NavbarMenuItem isMobile={ isMobile } name={ 'Messages' }>
		<IconButton color={'inherit'}>
			<Badge badgeContent={ numberOfNotifications } color={ color ?? 'secondary' }>
				<MailIcon/>
			</Badge>
		</IconButton>
	</NavbarMenuItem>
);


export default NavbarMessages;
