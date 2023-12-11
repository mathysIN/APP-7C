function path = get_resource_path(resource_name)
    main_path = mfilename('fullpath');
    main_folder = fileparts(main_path);
    path = fullfile(main_folder, '../../', 'files', resource_name);
end
