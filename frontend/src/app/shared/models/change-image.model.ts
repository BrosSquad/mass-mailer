export type Image = 'avatar' | 'backgroundImage';

export interface SaveImageModel {
    path: string;
    type: Image
}

export interface ChangeImageModel {
    file: File,
    type: Image
}