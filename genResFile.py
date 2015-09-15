#!/usr/bin/python
import os
import sys
import re

subPattern = re.compile(r"""[\.-]""")
excludePat = re.compile(r"""\.DS_Store""")
def findCurDir( tree_top ):
    resDefBlock = '';
    gResVarName = '';
    varNames = {};
    for dir, subdirs, files in os.walk( tree_top + "/res"):        
        for file in files:
            if(excludePat.search( file ) != None ): continue;
            filepath = os.path.join(dir, file)[2:]
            resName = subPattern.sub(r'_', file);
            while(resName in varNames):
                tmp = resName;
                resName += str(varNames[tmp]);
                varNames[tmp] += 1;
            varNames[resName] = 0;
            resDef = "    %s : \"%s\",\n" % (resName, filepath)
            resDefBlock += resDef;
            gResVarName += '    res.%s,\n' % (resName);
            
    return resDefBlock[0:-2], gResVarName[0:-2];

if __name__ == '__main__':
    # run backup on the specified directory (default: the current directory)
    try: tree_top = sys.argv[1]
    except IndexError: 
        tree_top = '.';
        rd, gr = findCurDir(tree_top)
        rd = "var res = {\n%s\n};" % (rd);
        gr = "var g_resources = [\n%s\n];" % (gr);
        gr = '''
var g_resources = [];
for (var i in res) {
    g_resources.push(res[i]);
}
                '''
        resourceJS = open(tree_top + "/src/resource.js", "w")
        resourceJS.write(rd);
        #resourceJS.write("\n\n");
        resourceJS.write(gr);
        resourceJS.close();

