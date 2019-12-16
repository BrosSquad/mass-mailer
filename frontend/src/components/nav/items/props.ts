import { PropsWithChildren } from "react";

export type NavbarMenuItemProps = PropsWithChildren<{
	isMobile: boolean;
	name?: string;
}>


export interface NavbarMenuProps extends NavbarMenuItemProps {
	color?: 'primary' | 'secondary' | 'default' | 'error';
	numberOfNotifications?: number;
}
