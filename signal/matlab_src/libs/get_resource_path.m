%------------------------------------------
% Groupe :          Groupe 7C
% Description :     Cette fonction génère le chemin d'accès complet à une ressource spécifiée,
%                   en utilisant le nom de la ressource et la structure du projet.
%
% Entrées :
%   resource_name   Chaîne      Nom de la ressource (fichier)
%
% Sorties :
%   path            Chaîne      Chemin d'accès complet à la ressource
%
% Modifiées :       Aucune
%
% Locales :
%   main_path       Chaîne      Chemin d'accès complet à ce fichier (get_resource_path.m)
%   main_folder     Chaîne      Dossier contenant le fichier get_resource_path.m
%------------------------------------------

function path = get_resource_path(resource_name)
    main_path = mfilename('fullpath');
    main_folder = fileparts(main_path);
    path = fullfile(main_folder, '../../', 'files', resource_name);
end